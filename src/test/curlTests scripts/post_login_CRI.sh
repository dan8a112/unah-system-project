#!/bin/bash
curl -d "mail=carlos.hernandez@gmail.com" -d "password=1234" http://localhost:3000/api/post/login/loginCRI | jq
