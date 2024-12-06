#!/bin/bash
curl "http://localhost:3000/api/get/admission/inscription/?id=1&idAdmissionProcess=1" | jq
