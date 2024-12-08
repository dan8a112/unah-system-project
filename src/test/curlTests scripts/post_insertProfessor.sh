#!/bin/bash
curl -d "identityNumber=0801-2004-03085" -d "names=Dorian" -d "lastNames=Samantha" -d "phoneNumber=3347-6290" -d "address=casita" -d "professorTypeId=1" -d "departmentId=3" -d "birthDate=2003-12-08" http://localhost:3000/api/post/professor | jq
