import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { 
  Select, 
  SelectContent, 
  SelectItem, 
  SelectTrigger, 
  SelectValue 
} from '@/components/ui/select';
import { Slider } from '@/components/ui/slider';
import { Search, Filter, ChevronDown } from 'lucide-react';
import Navbar from '@/components/Navbar';
import CarCard from '@/components/CarCard';
import { carsData } from '@/types/car';

const Catalog = () => {
  const [priceRange, setPriceRange] = useState([0, 25000]);
  const [searchQuery, setSearchQuery] = useState('');
  const [category, setCategory] = useState('all');
  const [showFilters, setShowFilters] = useState(false);
  
  // Filter cars based on selected criteria
  const filteredCars = carsData.filter(car => {
    const matchesSearch = car.name.toLowerCase().includes(searchQuery.toLowerCase()) || 
                          car.brand.toLowerCase().includes(searchQuery.toLowerCase()) ||
                          car.model.toLowerCase().includes(searchQuery.toLowerCase());
                          
    const matchesCategory = category === 'all' || car.category === category;
    const matchesPrice = car.pricePerDay >= priceRange[0] && car.pricePerDay <= priceRange[1];
    
    return matchesSearch && matchesCategory && matchesPrice;
  });

  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      
      {/* Hero Section */}
      <section className="pt-32 pb-16 relative">
        <div className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1544829099-b9a0c07fad1a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1527&q=80')] bg-cover bg-center opacity-10"></div>
        <div className="container mx-auto px-4 relative z-10">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-playfair font-bold mb-6">Каталог автомобилей</h1>
            <p className="text-xl text-muted-foreground mb-8">
              Выберите автомобиль вашей мечты из нашей коллекции премиальных моделей
            </p>
          </div>
        </div>
      </section>
      
      {/* Search & Filters */}
      <section className="py-8 border-y">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div className="relative flex-1 max-w-md">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Поиск по названию, марке или модели..."
                className="pl-10"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
            </div>
            
            <div className="flex items-center space-x-4">
              <Select value={category} onValueChange={setCategory}>
                <SelectTrigger className="w-[180px]">
                  <SelectValue placeholder="Категория" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">Все категории</SelectItem>
                  <SelectItem value="Спорткар">Спорткар</SelectItem>
                  <SelectItem value="Премиум">Премиум</SelectItem>
                  <SelectItem value="Бизнес">Бизнес</SelectItem>
                  <SelectItem value="Внедорожник">Внедорожник</SelectItem>
                  <SelectItem value="Эконом">Эконом</SelectItem>
                </SelectContent>
              </Select>
              
              <Button
                variant="outline"
                className="flex items-center"
                onClick={() => setShowFilters(!showFilters)}
              >
                <Filter className="mr-2 h-4 w-4" />
                Фильтры
                <ChevronDown className={`ml-2 h-4 w-4 transition-transform ${showFilters ? 'rotate-180' : ''}`} />
              </Button>
            </div>
          </div>
          
          {showFilters && (
            <div className="mt-6 p-6 border rounded-md bg-secondary/5 animate-fade-in">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                  <h3 className="text-sm font-medium mb-4">Стоимость аренды (₽ в день)</h3>
                  <div className="px-2">
                    <Slider
                      defaultValue={[priceRange[0], priceRange[1]]}
                      max={25000}
                      step={500}
                      onValueChange={(value) => setPriceRange(value as number[])}
                      className="my-6"
                    />
                    <div className="flex justify-between text-sm text-muted-foreground">
                      <span>{priceRange[0].toLocaleString('ru-RU')} ₽</span>
                      <span>{priceRange[1].toLocaleString('ru-RU')} ₽</span>
                    </div>
                  </div>
                </div>
                
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <h3 className="text-sm font-medium mb-2">Тип топлива</h3>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Все типы" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="all">Все типы</SelectItem>
                        <SelectItem value="Бензин">Бензин</SelectItem>
                        <SelectItem value="Дизель">Дизель</SelectItem>
                        <SelectItem value="Электро">Электро</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                  
                  <div>
                    <h3 className="text-sm font-medium mb-2">Коробка передач</h3>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Все типы" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="all">Все типы</SelectItem>
                        <SelectItem value="Автомат">Автомат</SelectItem>
                        <SelectItem value="Механика">Механика</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>
              </div>
            </div>
          )}
        </div>
      </section>
      
      {/* Cars Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          {filteredCars.length > 0 ? (
            <>
              <div className="mb-8 flex justify-between items-center">
                <p className="text-muted-foreground">Найдено {filteredCars.length} автомобилей</p>
                <Select defaultValue="price_asc">
                  <SelectTrigger className="w-[180px]">
                    <SelectValue placeholder="Сортировка" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="price_asc">Цена: по возрастанию</SelectItem>
                    <SelectItem value="price_desc">Цена: по убыванию</SelectItem>
                    <SelectItem value="name_asc">Название: А-Я</SelectItem>
                    <SelectItem value="name_desc">Название: Я-А</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {filteredCars.map((car) => (
                  <CarCard key={car.id} car={car} />
                ))}
              </div>
            </>
          ) : (
            <div className="text-center py-16">
              <h3 className="text-2xl font-playfair mb-4">Автомобили не найдены</h3>
              <p className="text-muted-foreground mb-8">Попробуйте изменить параметры поиска или фильтрации</p>
              <Button 
                variant="outline" 
                onClick={() => {
                  setSearchQuery('');
                  setCategory('all');
                  setPriceRange([0, 25000]);
                }}
              >
                Сбросить фильтры
              </Button>
            </div>
          )}
        </div>
      </section>
      
      {/* Footer */}
      <footer className="py-12 bg-background border-t">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h3 className="text-xl font-playfair font-bold mb-4">АВТОПАРК</h3>
              <p className="text-muted-foreground mb-6">Премиальный сервис аренды автомобилей с возможностью 3D просмотра</p>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Навигация</h3>
              <ul className="space-y-2">
                <li><Link to="/" className="text-muted-foreground hover:text-primary transition">Главная</Link></li>
                <li><Link to="/catalog" className="text-muted-foreground hover:text-primary transition">Каталог</Link></li>
                <li><Link to="/about" className="text-muted-foreground hover:text-primary transition">О нас</Link></li>
                <li><Link to="/contact" className="text-muted-foreground hover:text-primary transition">Контакты</Link></li>
              </ul>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Контакты</h3>
              <ul className="space-y-2 text-muted-foreground">
                <li>Москва, ул. Примерная, 123</li>
                <li>+7 (999) 123-45-67</li>
                <li>info@autopark.ru</li>
              </ul>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Подписаться на новости</h3>
              <div className="flex">
                <input 
                  type="email" 
                  placeholder="Ваш email" 
                  className="bg-muted px-4 py-2 text-sm rounded-l-md focus:outline-none w-full"
                />
                <Button variant="default" className="rounded-l-none">OK</Button>
              </div>
            </div>
          </div>
          
          <div className="border-t mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p className="text-muted-foreground text-sm">© {new Date().getFullYear()} АВТОПАРК. Все права защищены.</p>
            <div className="flex items-center space-x-4 mt-4 md:mt-0">
              <a href="#" className="text-muted-foreground hover:text-primary transition">Политика конфиденциальности</a>
              <a href="#" className="text-muted-foreground hover:text-primary transition">Условия использования</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Catalog;
