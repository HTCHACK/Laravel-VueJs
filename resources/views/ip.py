import json,urllib.request

url = "http://ip-api.com/json/"
buka = urllib.request.urlopen(url)
baca = buka.read()
hasil = json.loads(baca)

print("YOUR IP:")
print(hasil["query"])
print("\nALL INFORMATIONS:")
print(hasil)
