#!/bin/bash
curl -d "identityNumber=0801-2004-03099" -d "names=Actualizado" -d "lastNames=Velasquez" -d "phoneNumber=3347-6290" -d "address=casita" -d "professorTypeId=1" -d "departmentId=3" -d "birthDate=2003-12-08" -d "active=false" http://localhost:3000/api/update/professor/professor?id=8 | jq
