#!/bin/bash
curl -d "mail=maria.ramirez@unah.edu.hn" -d "password=1234" http://localhost:3000/api/post/login/loginAdmission | jq
