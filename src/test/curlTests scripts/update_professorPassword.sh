#!/bin/bash
curl -d "newPassword=asdf" -d "currentPassword=1234" http://localhost:3000/api/update/professor/password?id=3 | jq
