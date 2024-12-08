#!/bin/bash
curl -d "idApplication=47" -d "idReviewer=3" -d "approved=0" -d "name=Samantha" -d "mail=dorian.contreras@unah.hn" http://localhost:3000/api/update/verifyApplication | jq
