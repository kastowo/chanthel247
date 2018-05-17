url="http://192.168.2.69:8081/"
if curl --output /dev/null --silent --head --fail "$url"; then
  echo "URL exists: $url"
else
  echo "URL does not exist: $url"
fi
