import { useRef } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { ChevronRight, Star, Calendar, Shield, Truck } from 'lucide-react';
import Navbar from '@/components/Navbar';
import Hero from '@/components/Hero';
import CarCard from '@/components/CarCard';
import CarViewer3D from '@/components/CarViewer3D';
import { carsData } from '@/types/car';

const Index = () => {
  const featuredCars = carsData.slice(0, 3);
  const featuredCarRef = useRef<HTMLDivElement>(null);

  const scrollToFeatured = () => {
    featuredCarRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <Hero />

      {/* Featured Cars Section */}
      <section ref={featuredCarRef} className="py-20 bg-secondary/30">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-12">
            <div>
              <h2 className="text-3xl md:text-4xl font-playfair mb-3">Премиальные автомобили</h2>
              <p className="text-muted-foreground max-w-2xl">Выберите автомобиль вашей мечты из нашей коллекции престижных моделей</p>
            </div>
            <Button asChild variant="outline" className="mt-4 md:mt-0">
              <Link to="/catalog">
                Посмотреть все
                <ChevronRight className="ml-1 h-4 w-4" />
              </Link>
            </Button>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {featuredCars.map((car) => (
              <CarCard key={car.id} car={car} />
            ))}
          </div>
        </div>
      </section>

      {/* 3D Model Showcase */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-playfair mb-6">Изучите автомобиль в 3D до бронирования</h2>
              <p className="text-muted-foreground mb-6">
                Наша уникальная технология позволяет вам рассмотреть автомобиль со всех сторон, 
                заглянуть внутрь и ознакомиться со всеми деталями перед принятием решения.
              </p>
              <ul className="space-y-4 mb-8">
                <li className="flex items-start">
                  <div className="bg-primary/10 p-2 rounded-full mr-4 mt-1">
                    <Star className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium mb-1">Детальный обзор экстерьера</h3>
                    <p className="text-muted-foreground text-sm">Изучите каждую деталь кузова, колесные диски и другие особенности</p>
                  </div>
                </li>
                <li className="flex items-start">
                  <div className="bg-primary/10 p-2 rounded-full mr-4 mt-1">
                    <Star className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium mb-1">Виртуальный салон</h3>
                    <p className="text-muted-foreground text-sm">Осмотрите салон автомобиля, оцените отделку и комфорт</p>
                  </div>
                </li>
                <li className="flex items-start">
                  <div className="bg-primary/10 p-2 rounded-full mr-4 mt-1">
                    <Star className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium mb-1">Интерактивное взаимодействие</h3>
                    <p className="text-muted-foreground text-sm">Открывайте двери, багажник и другие элементы в 3D пространстве</p>
                  </div>
                </li>
              </ul>
              <Button asChild size="lg" className="rounded-none">
                <Link to="/catalog">
                  Выбрать автомобиль для 3D просмотра
                </Link>
              </Button>
            </div>
            <div className="order-first lg:order-last mb-10 lg:mb-0">
              <CarViewer3D 
                modelUrl="/models/car-sample.glb"
                fallbackImageUrl="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
              />
            </div>
          </div>
        </div>
      </section>

      {/* How It Works */}
      <section className="py-20 bg-secondary/30">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-playfair mb-3">Как работает бронирование</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">Простой процесс в несколько шагов для получения автомобиля вашей мечты</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div className="flex flex-col items-center text-center">
              <div className="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <Calendar className="h-8 w-8 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-3">1. Выберите дату</h3>
              <p className="text-muted-foreground">Укажите желаемые даты аренды автомобиля и изучите доступные варианты</p>
            </div>
            
            <div className="flex flex-col items-center text-center">
              <div className="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <Star className="h-8 w-8 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-3">2. Выберите автомобиль</h3>
              <p className="text-muted-foreground">Изучите характеристики, просмотрите галерею и 3D модель автомобиля</p>
            </div>
            
            <div className="flex flex-col items-center text-center">
              <div className="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <Shield className="h-8 w-8 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-3">3. Подтвердите бронь</h3>
              <p className="text-muted-foreground">Внесите предоплату и получите подтверждение брони на указанные даты</p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24 bg-primary text-primary-foreground">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-playfair mb-6">Готовы забронировать автомобиль мечты?</h2>
          <p className="text-primary-foreground/80 max-w-2xl mx-auto mb-10">
            Наш автопарк премиальных автомобилей ждет вас. Каждый автомобиль прошел полную техническую проверку и готов к поездке.
          </p>
          <div className="flex flex-col sm:flex-row justify-center gap-4">
            <Button asChild size="lg" variant="outline" className="bg-transparent border-white/30 hover:bg-white/10 text-white">
              <Link to="/catalog">
                Выбрать автомобиль
              </Link>
            </Button>
            <Button asChild size="lg" className="bg-white text-primary hover:bg-white/90">
              <Link to="/contact">
                Связаться с нами
              </Link>
            </Button>
          </div>
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

export default Index;
