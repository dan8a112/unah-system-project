#!/bin/bash
curl -d "mail=juan.perez@unah.edu.hn" -d "password=1234" http://localhost:3000/api/post/login/loginSEDP | jq
