#!/bin/bash
touch test.html

cat > test.html << EOF

<!DOCTYPE html>
<html>
  <head>
    <title>New Page</title>
  </head>
  <body>
    <h1>!</h1>
  </body>
</html>

EOF
