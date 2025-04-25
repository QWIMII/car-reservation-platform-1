import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { BookOpen, ArrowRight, Users, Clock, Award } from 'lucide-react';
import Navbar from '@/components/Navbar';

const About = () => {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      
      {/* Hero Section */}
      <section className="pt-32 pb-20 relative">
        <div className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1520&q=80')] bg-cover bg-center opacity-10"></div>
        <div className="container mx-auto px-4 relative z-10">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-playfair font-bold mb-6">История нашего автопарка</h1>
            <p className="text-xl text-muted-foreground mb-8">
              Более 10 лет мы воплощаем мечты о премиальных автомобилях, 
              предоставляя исключительный опыт вождения и безупречный сервис.
            </p>
            <Button asChild size="lg" className="rounded-none group">
              <Link to="/catalog">
                Выбрать автомобиль
                <ArrowRight className="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" />
              </Link>
            </Button>
          </div>
        </div>
      </section>
      
      {/* Our Story */}
      <section className="py-20 bg-secondary/10">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-playfair mb-6">Наша история</h2>
              <div className="space-y-6 text-muted-foreground">
                <p>
                  История нашего автопарка началась в 2012 году, когда группа энтузиастов 
                  и ценителей роскошных автомобилей решила создать сервис, который предоставлял 
                  бы не просто аренду машин, а настоящие впечатления от вождения эксклюзивных моделей.
                </p>
                <p>
                  Начав с небольшой коллекции из пяти премиальных автомобилей, мы быстро завоевали 
                  репутацию благодаря нашему вниманию к деталям и персонализированному подходу к каждому клиенту.
                </p>
                <p>
                  Сегодня наш автопарк насчитывает более 50 эксклюзивных моделей от ведущих мировых 
                  производителей. Мы постоянно обновляем коллекцию, добавляя самые инновационные и 
                  желанные автомобили современности.
                </p>
              </div>
              <div className="mt-8 flex items-center space-x-4">
                <div className="bg-primary/10 p-3 rounded-full">
                  <BookOpen className="h-6 w-6 text-primary" />
                </div>
                <p className="font-medium">Более 10 лет безупречного сервиса</p>
              </div>
            </div>
            <div className="relative aspect-[4/3] bg-muted rounded-md overflow-hidden">
              <img 
                src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" 
                alt="История автопарка" 
                className="object-cover w-full h-full"
              />
            </div>
          </div>
        </div>
      </section>
      
      {/* Why Choose Us */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <h2 className="text-3xl md:text-4xl font-playfair mb-6">Почему выбирают нас</h2>
            <p className="text-muted-foreground">
              Мы стремимся предоставить исключительный опыт аренды премиальных автомобилей, 
              сочетающий роскошь, удобство и первоклассный сервис.
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div className="p-8 bg-secondary/10 rounded-md">
              <div className="bg-primary/10 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                <Award className="h-6 w-6 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-4">Премиальный автопарк</h3>
              <p className="text-muted-foreground">
                Эксклюзивная коллекция автомобилей класса люкс от ведущих мировых производителей, 
                регулярно обновляемая новинками.
              </p>
            </div>
            
            <div className="p-8 bg-secondary/10 rounded-md">
              <div className="bg-primary/10 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                <Users className="h-6 w-6 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-4">Персонализированный сервис</h3>
              <p className="text-muted-foreground">
                Индивидуальный подход к каждому клиенту, консультации по выбору автомобиля 
                и гибкие условия аренды.
              </p>
            </div>
            
            <div className="p-8 bg-secondary/10 rounded-md">
              <div className="bg-primary/10 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                <Clock className="h-6 w-6 text-primary" />
              </div>
              <h3 className="text-xl font-medium mb-4">Оперативность и удобство</h3>
              <p className="text-muted-foreground">
                Быстрое бронирование через онлайн-платформу, доставка автомобиля в удобное 
                для вас место и время.
              </p>
            </div>
          </div>
        </div>
      </section>
      
      {/* CTA Section */}
      <section className="py-20 bg-primary text-primary-foreground">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-playfair mb-6">Готовы испытать премиальный автомобиль?</h2>
          <p className="text-primary-foreground/80 max-w-2xl mx-auto mb-10">
            Выберите автомобиль вашей мечты из нашей коллекции и забронируйте его прямо сейчас.
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

export default About;
