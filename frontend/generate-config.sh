#!/bin/bash

cat <<EOF > src/app.config.ts
export const config = {
  apiUrl: '$BACKEND_API_URL'
};
EOF
