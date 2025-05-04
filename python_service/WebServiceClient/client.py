import requests

url = 'http://127.0.0.1:8000/api/foods.php'
response = requests.get(url)

if response.status_code == 200:
    foods = response.json()
    for food in foods:
        print(f"{food['name']} - ${food['price']} ({food['category']})")
else:
    print("Failed to retrieve food data.")
