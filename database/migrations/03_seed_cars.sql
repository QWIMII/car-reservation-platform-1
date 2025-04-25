-- Сокращенный пример заполнения таблицы автомобилей (10 примеров из разных категорий)
-- В полной версии необходимо добавить все 50 автомобилей

-- Супербизнес автомобили
INSERT INTO cars (name, brand, model, year, transmission, engine_power, fuel_type, seats, price_per_day, deposit, description, main_image, model_3d_url, is_3d_ready, is_new, is_available, category_id) VALUES
('Rolls-Royce Phantom', 'Rolls-Royce', 'Phantom', 2023, 'Автомат', 571, 'Бензин', 5, 45000.00, 200000.00, 'Эталон роскоши и престижа, воплощающий изысканность и элегантность.', 'https://images.unsplash.com/photo-1631295868223-63265b40d9e4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80', '/models/rolls-royce-phantom.glb', TRUE, TRUE, TRUE, 1),
('Bentley Bentayga', 'Bentley', 'Bentayga', 2023, 'Автомат', 626, 'Бензин', 7, 38000.00, 180000.00, 'Роскошный внедорожник высочайшего класса с непревзойденной отделкой салона.', 'https://images.unsplash.com/photo-1566473965997-3de9c817e938?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', '/models/bentley-bentayga.glb', TRUE, TRUE, TRUE, 1);

-- Porsche
INSERT INTO cars (name, brand, model, year, transmission, engine_power, fuel_type, seats, price_per_day, deposit, description, main_image, model_3d_url, is_3d_ready, is_new, is_available, category_id) VALUES
('Porsche 911 GT3', 'Porsche', '911 GT3', 2023, 'Автомат', 510, 'Бензин', 2, 26000.00, 90000.00, 'Спортивный автомобиль Porsche с гоночными технологиями для трека и дорог общего пользования.', 'https://images.unsplash.com/photo-1611651338412-8403fa6e3599?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80', '/models/porsche-911-gt3.glb', TRUE, TRUE, TRUE, 2),
('Porsche Taycan Turbo S', 'Porsche', 'Taycan Turbo S', 2023, 'Автомат', 761, 'Электро', 4, 23000.00, 75000.00, 'Высокопроизводительный электрический седан с фирменным спортивным характером Porsche.', 'https://images.unsplash.com/photo-1608985346477-d5374e9ea100?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', '/models/porsche-taycan.glb', TRUE, TRUE, TRUE, 6);

-- Бизнес автомобили
INSERT INTO cars (name, brand, model, year, transmission, engine_power, fuel_type, seats, price_per_day, deposit, description, main_image, model_3d_url, is_3d_ready, is_new, is_available, category_id) VALUES
('Mercedes-Benz S-Class', 'Mercedes-Benz', 'S-Class', 2023, 'Автомат', 435, 'Бензин', 5, 15000.00, 50000.00, 'Флагманский седан Mercedes-Benz, воплощающий роскошь и инновации.', 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', '/models/mercedes-s-class.glb', TRUE, TRUE, TRUE, 4),
('BMW 7 Series', 'BMW', '7 Series', 2023, 'Автомат', 530, 'Бензин', 5, 14000.00, 45000.00, 'Представительский седан BMW с передовыми технологиями и безупречным комфортом.', 'https://images.unsplash.com/photo-1556189250-72ba954cfc2b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', '/models/bmw-7-series.glb', TRUE, FALSE, TRUE, 4);

-- Спортивные автомобили
INSERT INTO cars (name, brand, model, year, transmission, engine_power, fuel_type, seats, price_per_day, deposit, description, main_image, model_3d_url, is_3d_ready, is_new, is_available, category_id) VALUES
('Ferrari Roma', 'Ferrari', 'Roma', 2022, 'Автомат', 620, 'Бензин', 2, 30000.00, 100000.00, 'Элегантное купе с узнаваемым итальянским стилем и великолепной динамикой.', 'https://images.unsplash.com/photo-1592303645522-5107b3c6703a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1149&q=80', '/models/ferrari-roma.glb', TRUE, FALSE, TRUE, 2),
('Lamborghini Huracán', 'Lamborghini', 'Huracán', 2022, 'Автомат', 640, 'Бензин', 2, 35000.00, 120000.00, 'Экзотический суперкар с захватывающим дизайном и невероятной производительностью.', 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1167&q=80', '/models/lamborghini-huracan.glb', TRUE, FALSE, TRUE, 2);

-- Эконом автомобили
INSERT INTO cars (name, brand, model, year, transmission, engine_power, fuel_type, seats, price_per_day, deposit, description, main_image, model_3d_url, is_3d_ready, is_new, is_available, category_id) VALUES
('Toyota Corolla', 'Toyota', 'Corolla', 2022, 'Автомат', 140, 'Бензин', 5, 4500.00, 15000.00, 'Надежный и экономичный седан для повседневных поездок.', 'https://images.unsplash.com/photo-1623869675781-80aa31012a5a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', '/models/toyota-corolla.glb', TRUE, FALSE, TRUE, 9),
('Volkswagen Golf', 'Volkswagen', 'Golf', 2022, 'Автомат', 150, 'Бензин', 5, 5000.00, 15000.00, 'Классический европейский хэтчбек с отличной управляемостью и экономичностью.', 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', '/models/volkswagen-golf.glb', TRUE, FALSE, TRUE, 9);
