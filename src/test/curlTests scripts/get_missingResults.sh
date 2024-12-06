#!/bin/bash
curl "http://localhost:3000/api/get/pagination/missingResults/?offset=0&counter=1" | jq
