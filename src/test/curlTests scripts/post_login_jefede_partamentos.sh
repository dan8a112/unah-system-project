#!/bin/bash
curl -d "mail=ana.lopez@unah.edu.hn" -d "password=1234" http://localhost:3000/api/post/login/loginDepartmentBoss| jq