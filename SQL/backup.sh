#!/bin/bash
mysqldump -uroot -p -h 3.65.146.44 --databases fontanelle --column-statistics=0 > ~/SCRIPTS/РУЧЕЕК/DUMP/$(date +"%d%m%Y").sql
