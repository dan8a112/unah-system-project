#!/bin/bash
curl "http://localhost:3000/api/get/pagination/allInscriptions/?idProcess=1&offset=0" | jq
