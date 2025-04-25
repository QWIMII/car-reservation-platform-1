<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование автомобиля - <?= $car['name'] ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ru.js"></script>
</head>
<body>
    <?php include TEMPLATE_PATH . '/partials/header.php'; ?>
    
    <main class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-playfair font-bold mb-8">Бронирование автомобиля</h1>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 mb-6 rounded-md">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="md:col-span-1">
                    <div class="sticky top-24">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                            <img src="<?= $car['image_url'] ?>" alt="<?= $car['name'] ?>" class="w-full h-48 object-cover">
                            
                            <div class="p-4">
                                <h2 class="text-xl font-bold mb-2"><?= $car['name'] ?></h2>
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <span><?= $car['year'] ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?= $car['transmission'] ?></span>
                                    <span class="mx-2">•</span>
                                    <span><?= $car['engine_power'] ?> л.с.</span>
                                </div>
                                
                                <div class="text-xl font-bold text-primary mb-2"><?= number_format($car['price_per_day'], 0, ',', ' ') ?> ₽ / день</div>
                                
                                <div class="text-sm text-gray-600">
                                    Залог: <?= number_format($car['deposit'], 0, ',', ' ') ?> ₽
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h3 class="font-bold mb-2">Особенности</h3>
                            <ul class="text-sm space-y-1">
                                <?php foreach ($car['features'] as $feature): ?>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <?= $feature ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <form action="/car/<?= $car['id'] ?>/book" method="POST" class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-6">Детали бронирования</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Дата начала</label>
                                <input type="text" id="start_date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" required>
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Дата окончания</label>
                                <input type="text" id="end_date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" required>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-1">Место получения</label>
                            <input type="text" id="pickup_location" name="pickup_location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="return_location" class="block text-sm font-medium text-gray-700 mb-1">Место возврата</label>
                            <input type="text" id="return_location" name="return_location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                            <div class="text-xs text-gray-500 mt-1">Оставьте пустым, если совпадает с местом получения</div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-2">Дополнительные опции</h3>
                            
                            <div class="space-y-3">
                                <?php foreach ($options as $key => $option): ?>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" id="<?= $key ?>" name="<?= $key ?>" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="<?= $key ?>" class="font-medium text-gray-700"><?= $option['name'] ?> (+<?= number_format($option['price'], 0, ',', ' ') ?> ₽/день)</label>
                                            <p class="text-gray-500"><?= $option['description'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Особые пожелания</label>
                            <textarea id="special_requests" name="special_requests" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"></textarea>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Стоимость аренды:</span>
                                <span id="base_price" class="font-medium">0 ₽</span>
                            </div>
                            
                            <div class="flex items-center justify-between mb-2 option-price hidden">
                                <span class="text-gray-600">Дополнительные опции:</span>
                                <span id="options_price" class="font-medium">0 ₽</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-lg font-bold">
                                <span>Итого:</span>
                                <span id="total_price">0 ₽</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <input type="hidden" id="total_price_input" name="total_price" value="0">
                            <button type="submit" class="w-full bg-primary text-white py-3 px-4 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition">
                                Забронировать автомобиль
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php include TEMPLATE_PATH . '/partials/footer.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Преобразование PHP массива в JavaScript
            const availableDates = <?= json_encode($availableDates) ?>;
            const carPrice = <?= $car['price_per_day'] ?>;
            const options = <?= json_encode($options) ?>;
            
            // Инициализация выбора дат
            const startDatePicker = flatpickr("#start_date", {
                locale: "ru",
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: [
                    function(date) {
                        // Отключаем даты, которые не доступны для бронирования
                        const dateString = date.toISOString().split('T')[0];
                        return !availableDates.includes(dateString);
                    }
                ],
                onChange: function(selectedDates, dateStr) {
                    // При изменении даты начала, обновляем минимальную дату для даты окончания
                    endDatePicker.set('minDate', dateStr);
                    updatePrice();
                }
            });
            
            const endDatePicker = flatpickr("#end_date", {
                locale: "ru",
                dateFormat: "Y-m-d",
                disable: [
                    function(date) {
                        // Отключаем даты, которые не доступны для бронирования
                        const dateString = date.toISOString().split('T')[0];
                        return !availableDates.includes(dateString);
                    }
                ],
                onChange: function() {
                    updatePrice();
                }
            });
            
            // Обработчики изменения дополнительных опций
            const optionCheckboxes = document.querySelectorAll('input[type="checkbox"]');
            optionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updatePrice);
            });
            
            // Функция обновления цены
            function updatePrice() {
                const startDate = startDatePicker.selectedDates[0];
                const endDate = endDatePicker.selectedDates[0];
                
                if (!startDate || !endDate) return;
                
                // Рассчитываем количество дней аренды
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 т.к. считаем и день начала, и день окончания
                
                // Базовая стоимость аренды
                const basePrice = carPrice * diffDays;
                document.getElementById('base_price').textContent = formatPrice(basePrice);
                
                // Стоимость дополнительных опций
                let optionsPrice = 0;
                optionCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const optionKey = checkbox.id;
                        optionsPrice += options[optionKey].price * diffDays;
                    }
                });
                
                if (optionsPrice > 0) {
                    document.getElementById('options_price').textContent = formatPrice(optionsPrice);
                    document.querySelector('.option-price').classList.remove('hidden');
                } else {
                    document.querySelector('.option-price').classList.add('hidden');
                }
                
                // Итоговая стоимость
                const totalPrice = basePrice + optionsPrice;
                document.getElementById('total_price').textContent = formatPrice(totalPrice);
                document.getElementById('total_price_input').value = totalPrice;
            }
            
            // Функция форматирования цены
            function formatPrice(price) {
                return price.toLocaleString('ru-RU') + ' ₽';
            }
        });
    </script>
</body>
</html>
