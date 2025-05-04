from flask import Flask, jsonify
from flask import send_from_directory

app = Flask(__name__)

@app.route('/api/western-food', methods=['GET'])
def get_western_food():
    foods = [
        {"id": 1,
        "name": "Grilled Chicken",
        "price": 15.90,
        "description": "Grilled chicken with tomato sauce",
        "image": "http://localhost:8001/images/grilled_chicken.jpg"},

        {"id": 2,
        "name": "Beef Steak",
        "price": 22.50,
        "description": "Steak with potatoes and onions",
        "image": "http://localhost:8001/images/beef_steak.jpg"},

        {"id": 3,
        "name": "Spaghetti Bolognese",
        "price": 12.80,
        "description": "Pasta with meat sauce",
        "image": "http://localhost:8001/images/spaghetti.jpg"},
    ]
    return jsonify(foods)

@app.route('/images/<filename>')
def get_image(filename):
    return send_from_directory('static/images', filename)

if __name__ == '__main__':
    app.run(port=8001)