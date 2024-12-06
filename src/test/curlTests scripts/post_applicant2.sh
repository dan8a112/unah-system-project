#!/bin/bash
curl -d "identityNumber=0801-2004-03085" -d "firstName=Dorian" -d "idFirstDegreeProgramChoice=1" -d "idSecondDegreeProgramChoice=3" -d "idRegionalCenterChoice=4" http://localhost:3000/api/post/application | jq
