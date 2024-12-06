#!/bin/bash
curl -d "mail=carlos.martinez@unah.edu.hn" -d "password=1234" http://localhost:3000/api/post/login/loginCoordinator| jq