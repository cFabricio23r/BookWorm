#!/bin/sh

## Redirecting Filehanders
ln -sf /proc/$$/fd/1 /log/stdout.log
ln -sf /proc/$$/fd/2 /log/stderr.log

## Pre execution handler
# pre_execution_handler() {
#     php artisan horizon:terminate
# }

## Post execution handler
post_execution_handler() {
    # Install/update composer dependencies
    # composer install \
    #     --optimize-autoloader \
    #     --no-interaction \
    #     --no-dev \
    #     --no-scripts \
    #     --ansi \
    #     --no-progress

    ## Starting services

    if [[ "${WEBSERVER_ENV}" == 1 ]]; then
        echo 'starting web server'

        # Run database migrations
        php artisan migrate --force

        # Clear and cache config
        php artisan config:cache

        # Clear and cache routes
        php artisan route:cache

        # Classmap Optimization
        php artisan optimize

        # Optimize permissions
        php artisan permission:cache-reset

        /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
    fi

    if [[ "${HORIZON_ENV}" == 1 ]]; then
        echo 'starting horizon server'
        /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord-horizon.conf
    fi

    if [[ "${WEBSOCKET_ENV}" == 1 ]]; then
        echo 'starting websocket server'
        /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord-websockets.conf
    fi

    if [[ "${QUEUES_ENV}" == 1 ]]; then
        echo 'starting queue server'
        /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord-queue.conf
    fi
}

## Sigterm Handler
sigterm_handler() {
    if [ $pid -ne 0 ]; then
        # the above if statement is important because it ensures
        # that the application has already started. without it you
        # could attempt cleanup steps if the application failed to
        # start, causing errors.
        kill -15 "$pid"
        wait "$pid"
        post_execution_handler
    fi
    exit 143 # 128 + 15 -- SIGTERM
}

## Setup signal trap
# on callback execute the specified handler
trap 'sigterm_handler' SIGTERM

## Initialization
pre_execution_handler

## Start Process
# run process in background and record PID
"$@" >/log/stdout.log 2>/log/stderr.log &
pid="$!"
# Application can log to stdout/stderr, /log/stdout.log or /log/stderr.log

## Wait forever until app dies
wait "$pid"
return_code="$?"

## Cleanup
post_execution_handler
# echo the return code of the application
exit $return_code
