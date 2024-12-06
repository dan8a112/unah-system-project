#!/bin/bash
curl -d "mail=pedro.castillo@unah.edu.hn" -d "password=1234" http://localhost:3000/api/post/login/loginProfessor | jq
