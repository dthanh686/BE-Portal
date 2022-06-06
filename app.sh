#!/bin/bash

set -eu
set -o pipefail

if [ -z "${1-}" ]; then
  echo "Please input {action} to execute command"
  echo "Example: [start|test-build|stop|restart|destroy|build|clean|exec|composer|npm|artisan|php_lint|php_fix]"
  echo "Usage: $ docker.sh {action}"
  exit;
else
  case "${1-}" in
    build|pull|exec)
      if [ -z "${2-}" ]; then
        echo "Input {service} to execute command if you dont want perform all"
        echo "Example: [web|app|redis]"
        echo "Usage: $ docker.sh {action} {service}"
      fi
      ;;
  esac
fi

echo "✹✹✹ Executing command ✹✹✹"
echo "UTC Time: $(TZ=UTC date '+%Y-%m-%d %H:%M:%S')"
echo "VN Time: $(TZ=Asia/Bangkok date '+%Y-%m-%d %H:%M:%S')"
echo "JST Time: $(TZ=Asia/Tokyo date '+%Y-%m-%d %H:%M:%S')"

# docker-compose up -d web

# docker-compose down
# docker-compose up -d --build web

#docker exec

#docker_remove_dangling_images

command_action=${1-}
command_service=${2-}
command_service_run=${3-}
docker_compose="/usr/local/bin/docker-compose"
phpcs="./vendor/bin/phpcs"
phpcbf="./vendor/bin/phpcbf"
docker_dev_yml="docker-compose.yml"

change_context_dir() {
  echo "------ Change exec command context dir ------"
  context_dir=$(dirname "$0")
  # Change execute context to project's directory
  cd $context_dir
}

create_volume() {
  name=${1-}
  volume_existing=$(docker volume ls --filter name=${name} --format '{{ .Name }}')
  echo "------ Create $name volume ------"
  if [ -z "$volume_existing" ]; then
    docker volume create $name
  else
    echo "$name volume existing"
  fi
}

remove_volume() {
  name=${1-}
  volume_existing=$(docker volume ls --filter name=${name} --format '{{ .Name }}')
  echo "------ Remove $name volume ------"
  if [ -z "$volume_existing" ]; then
    docker volume rm $name
  else
    echo "$name volume is not existing"
  fi
}

run_each_command() {
  service=${1:-""}
  echo $2
  shift
  cmds=("$@")
  for (( i = 0; i < ${#cmds[@]}; i++ )); do
    ${cmds[$i]} ${service}
  done
}

docker_wrapper() {
  message=${1:-}
  service=${2:-}
  shift 2
  cmds=("$@")
  case "$service" in
    "")
      echo "------ $message [ALL] ------"
      run_each_command "" "${cmds[@]}"
      ;;
    *)
      echo "------ $message [$service] ------"
      run_each_command "$service" ${cmds[@]}
      ;;
  esac
}


docker_up() {
  message="Up"
  service=${1:-}
  cmds=("$docker_compose -f $docker_dev_yml up -d web")
  docker_wrapper "$message" "$service" "${cmds[@]}"
}

docker_down() {
  message="Down"
  service=${1:-}
  cmds=("$docker_compose -f $docker_dev_yml down")
  docker_wrapper "$message" "$service" "${cmds[@]}"
}

docker_restart() {
  message="Restart"
  service=${1:-}
  cmds=("$docker_compose -f $docker_dev_yml restart")
  docker_wrapper "$message" "$service" "${cmds[@]}"
}

docker_build() {
  message="Re-build"
  service=${1:-}
  cmds=("$docker_compose -f $docker_dev_yml build --force-rm")
  docker_wrapper "$message" "$service" "${cmds[@]}"
}

docker_remove_dangling_images() {
  echo "------ Removing all dangling images ------"
  dangling_images=$(docker images -f "dangling=true" -q)
  if [ -n "$dangling_images" ]; then
    docker rmi $(docker images -f "dangling=true" -q)
  fi
}

docker_exec() {
  message="Exec"
  service=${1:-}
  command=${2:-}
  if [ -z "$command" ]; then
    command="sh"
  fi
  $docker_compose -f $docker_dev_yml exec "$service" $command
}

docker_run() {
  message="Run"
  service=${1:-}
  command=${2:-}
  if [ -z "$command" ]; then
      command="-v"
  fi
  $docker_compose -f $docker_dev_yml run --rm "$service" $command
}

# ACTION
action_start() {
  change_context_dir
  create_volume "mysql_data"
  docker_up $command_service
}

action_stop() {
  change_context_dir
  docker_down $command_service
}

action_destroy() {
  change_context_dir
  docker_down $command_service
  remove_volume "mysql_data"
}

action_build() {
  change_context_dir
  docker_build
}

# If you make changes to your docker-compose.yml configuration
# these changes are not reflected after running this command.
action_restart() {
  change_context_dir
  docker_restart $command_service
}

action_clean() {
  change_context_dir
  docker_remove_dangling_images
}

action_exec() {
  change_context_dir
  docker_exec $command_service $command_service_run
}

action_composer() {
  change_context_dir
  command_service_run=$command_service
  command_service="composer"
  docker_run $command_service $command_service_run
}

action_npm() {
  change_context_dir
  command_service_run=$command_service
  command_service="npm"
  docker_run $command_service $command_service_run
}

action_artisan() {
  change_context_dir
  command_service_run=$command_service
  command_service="artisan"
  docker_run $command_service $command_service_run
}

action_php_lint() {
    $phpcs --standard=VnextCS --encoding=utf-8 .
}

action_php_fix() {
    $phpcbf --standard=VnextCS .
}

#--- END ACTION
case "$command_action" in
  "start")
    action_start
    ;;
  "test-build")
      action_destroy
      action_build
      action_start
      ;;
  "stop")
      action_stop
      ;;
  "restart")
      action_restart
      ;;
  "destroy")
      action_destroy
      ;;
  "build")
      action_build
      ;;
  "clean")
      action_clean
      ;;
  "exec")
      action_exec
      ;;
  "composer")
      action_composer
      ;;
  "npm")
      action_npm
      ;;
  "artisan")
      action_artisan
      ;;
  "php_lint")
      action_php_lint
      ;;
  "php_fix")
      action_php_fix
      ;;
  *)
    echo "Unknown action: $command_action"
esac