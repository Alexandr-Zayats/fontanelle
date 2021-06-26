#!/bin/bash
mysqldump -uroot -p -h 3.65.146.44 --databases fontanelle > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%Y-%m-%d-(%H:%M)").sql
#mysqldump -uroot -p -h 3.65.146.44 -D fontanelle > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%Y-%m-%d-(%H:%M)").sql
