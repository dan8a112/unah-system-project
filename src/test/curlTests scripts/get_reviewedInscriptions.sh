#!/bin/bash
curl "http://localhost:3000/api/get/pagination/reviewedInscriptions/?idReviewer=1&offset=0" | jq
