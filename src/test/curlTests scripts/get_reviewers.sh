#!/bin/bash
curl "http://localhost:3000/api/get/pagination/reviewers/?idProcess=1&offset=0" | jq
