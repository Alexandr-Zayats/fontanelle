#!/bin/bash

# mysqldump -uroot -p -h 3.65.146.44 --databases fontanelle > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%Y-%m-%d-(%H:%M)").sql
mysqldump --column-statistics=0 -uroot -p -h 10.161.168.43 --events --databases fontanelle > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%Y-%m-%d-(%H:%M)").sql
#mysqldump -uroot -p -h 3.65.146.44 -D fontanelle > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%Y-%m-%d-(%H:%M)").sql
