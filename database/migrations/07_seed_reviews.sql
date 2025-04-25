-- Добавление отзывов

-- Иван Петров (id = 2) оставляет отзыв о Rolls-Royce Phantom (id = 1) после бронирования (id = 1)
INSERT INTO reviews (user_id, car_id, reservation_id, rating, comment) 
VALUES (2, 1, 1, 5, 'Превосходный автомобиль! Комфорт и динамика на высшем уровне. Определенно буду арендовать снова.');

-- Иван Петров (id = 2) оставляет отзыв о Toyota Corolla (id = 9) после бронирования (id = 7)
INSERT INTO reviews (user_id, car_id, reservation_id, rating, comment) 
VALUES (2, 9, 7, 4, 'Надежный и экономичный автомобиль. Идеально подошел для повседневных поездок по городу.');

-- Мария Сидорова (id = 3) оставляет отзыв о Bentley Bentayga (id = 2) после бронирования (id = 3)
INSERT INTO reviews (user_id, car_id, reservation_id, rating, comment) 
VALUES (3, 2, 3, 5, 'Идеальный выбор для бизнес-поездок. Презентабельный внешний вид и комфортный салон.');

-- Алексей Кузнецов (id = 4) оставляет отзыв о BMW 7 Series (id = 6) после бронирования (id = 6)
INSERT INTO reviews (user_id, car_id, reservation_id, rating, comment) 
VALUES (4, 6, 6, 4, 'Отличный автомобиль, очень удобный и мощный. Единственный минус - расход топлива выше ожидаемого.');
