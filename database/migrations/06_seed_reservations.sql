-- Добавление бронирований

-- Иван Петров (id = 2) бронирует Rolls-Royce Phantom (id = 1)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (2, 1, '2023-09-15', '2023-09-18', 135000.00, 'completed', 'paid');

-- Иван Петров (id = 2) бронирует Porsche 911 GT3 (id = 3)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (2, 3, '2023-11-20', '2023-11-25', 130000.00, 'active', 'paid');

-- Мария Сидорова (id = 3) бронирует Bentley Bentayga (id = 2)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (3, 2, '2023-10-05', '2023-10-10', 190000.00, 'completed', 'paid');

-- Алексей Кузнецов (id = 4) бронирует Porsche Taycan Turbo S (id = 4)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (4, 4, '2023-12-01', '2023-12-05', 92000.00, 'active', 'paid');

-- Мария Сидорова (id = 3) бронирует Mercedes-Benz S-Class (id = 5)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (3, 5, '2023-11-15', '2023-11-18', 45000.00, 'active', 'paid');

-- Алексей Кузнецов (id = 4) бронирует BMW 7 Series (id = 6)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (4, 6, '2023-08-10', '2023-08-15', 70000.00, 'completed', 'paid');

-- Иван Петров (id = 2) бронирует Toyota Corolla (id = 9)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (2, 9, '2023-07-20', '2023-07-25', 22500.00, 'completed', 'paid');

-- Мария Сидорова (id = 3) бронирует Volkswagen Golf (id = 10)
INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status, payment_status) 
VALUES (3, 10, '2023-12-20', '2023-12-25', 25000.00, 'active', 'pending');
