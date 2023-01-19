### generate doc 
```
sudo apidoc -i ./app/Http/Controllers -o ./public/doc -f ".*\\.php$" -c ./apidoc.json
sudo rm ./public/assets -rf
sudo mv ./public/doc/assets/ ./public
```