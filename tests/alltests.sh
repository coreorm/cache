#!/bin/bash
export SET ENABLE_DEBUG=no

echo 'Manager Tests'
echo '============='
phpunit cases/manager
echo ''

export SET ENABLE_DEBUG=yes

