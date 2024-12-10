#!/bin/bash
curl  GET "http://localhost:2000/api/get/pagination/studentHistory/index.php?id=20181000001&offset=30" | jq
