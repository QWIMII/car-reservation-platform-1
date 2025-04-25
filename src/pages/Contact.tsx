import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Phone, Mail, MapPin, Clock, Send } from 'lucide-react';
import Navbar from '@/components/Navbar';

const Contact = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    message: ''
  });

  const [submitted, setSubmitted] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log("Form submitted:", formData);
    // Здесь может быть интеграция с API для отправки формы
    setSubmitted(true);
    // Сброс формы через 3 секунды
    setTimeout(() => {
      setFormData({
        name: '',
        email: '',
        phone: '',
        message: ''
      });
      setSubmitted(false);
    }, 3000);
  };

  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      
      {/* Hero Section */}
      <section className="pt-32 pb-20 bg-primary text-primary-foreground">
        <div className="container mx-auto px-4">
          <h1 className="text-4xl md:text-5xl font-playfair font-medium mb-6">Свяжитесь с нами</h1>
          <p className="text-xl max-w-2xl">
            Мы готовы ответить на все ваши вопросы о наших автомобилях и услугах. Заполните форму или воспользуйтесь контактной информацией ниже.
          </p>
        </div>
      </section>

      {/* Contact Content */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            {/* Contact Form */}
            <div>
              <h2 className="text-3xl font-playfair mb-8">Написать нам</h2>
              
              {submitted ? (
                <div className="bg-green-50 border border-green-200 text-green-700 p-8 rounded-md">
                  <h3 className="text-xl font-medium mb-2">Сообщение отправлено!</h3>
                  <p>Спасибо за обращение. Мы свяжемся с вами в ближайшее время.</p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-6">
                  <div>
                    <label htmlFor="name" className="block text-sm font-medium mb-2">Ваше имя</label>
                    <Input 
                      id="name"
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      required
                      className="w-full"
                    />
                  </div>
                  
                  <div>
                    <label htmlFor="email" className="block text-sm font-medium mb-2">Email</label>
                    <Input 
                      id="email"
                      name="email"
                      type="email"
                      value={formData.email}
                      onChange={handleChange}
                      required
                      className="w-full"
                    />
                  </div>
                  
                  <div>
                    <label htmlFor="phone" className="block text-sm font-medium mb-2">Телефон</label>
                    <Input 
                      id="phone"
                      name="phone"
                      value={formData.phone}
                      onChange={handleChange}
                      className="w-full"
                    />
                  </div>
                  
                  <div>
                    <label htmlFor="message" className="block text-sm font-medium mb-2">Сообщение</label>
                    <Textarea 
                      id="message"
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      required
                      className="w-full min-h-[150px]"
                    />
                  </div>
                  
                  <Button type="submit" className="w-full md:w-auto" size="lg">
                    <Send className="mr-2 h-4 w-4" />
                    Отправить сообщение
                  </Button>
                </form>
              )}
            </div>
            
            {/* Contact Information */}
            <div>
              <h2 className="text-3xl font-playfair mb-8">Контактная информация</h2>
              
              <div className="space-y-8">
                <div className="flex items-start">
                  <div className="bg-primary/10 p-3 rounded-full mr-4">
                    <MapPin className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium text-lg mb-1">Адрес</h3>
                    <p className="text-muted-foreground">Москва, ул. Автомобильная, 123</p>
                    <p className="text-muted-foreground">БЦ "Престиж", 5 этаж</p>
                  </div>
                </div>
                
                <div className="flex items-start">
                  <div className="bg-primary/10 p-3 rounded-full mr-4">
                    <Phone className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium text-lg mb-1">Телефон</h3>
                    <p className="text-muted-foreground">+7 (495) 123-45-67 (Общие вопросы)</p>
                    <p className="text-muted-foreground">+7 (495) 765-43-21 (Бронирование)</p>
                  </div>
                </div>
                
                <div className="flex items-start">
                  <div className="bg-primary/10 p-3 rounded-full mr-4">
                    <Mail className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium text-lg mb-1">Email</h3>
                    <p className="text-muted-foreground">info@meowvest.ru</p>
                    <p className="text-muted-foreground">booking@meowvest.ru</p>
                  </div>
                </div>
                
                <div className="flex items-start">
                  <div className="bg-primary/10 p-3 rounded-full mr-4">
                    <Clock className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-medium text-lg mb-1">Часы работы</h3>
                    <p className="text-muted-foreground">Пн-Пт: 9:00 - 20:00</p>
                    <p className="text-muted-foreground">Сб-Вс: 10:00 - 18:00</p>
                  </div>
                </div>
              </div>
              
              {/* Map */}
              <div className="mt-10 h-[300px] bg-muted rounded-md overflow-hidden">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.0804115307!2d37.618705!3d55.753033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a50b315e573%3A0xa886bf5a3d9b2e68!2sThe%20Moscow%20Kremlin!5e0!3m2!1sen!2sru!4v1619422409943!5m2!1sen!2sru" 
                  width="100%" 
                  height="100%" 
                  style={{ border: 0 }} 
                  allowFullScreen 
                  loading="lazy"
                  title="Карта расположения MEOWVEST"
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      
      {/* FAQ Section */}
      <section className="py-20 bg-secondary/30">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-playfair text-center mb-12">Часто задаваемые вопросы</h2>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div className="bg-card p-6 rounded-md">
              <h3 className="text-xl font-medium mb-3">Как забронировать автомобиль?</h3>
              <p className="text-muted-foreground">Бронирование доступно онлайн через личный кабинет или по телефону. Выберите автомобиль в каталоге, укажите даты и заполните форму бронирования.</p>
            </div>
            
            <div className="bg-card p-6 rounded-md">
              <h3 className="text-xl font-medium mb-3">Какие документы нужны для аренды?</h3>
              <p className="text-muted-foreground">Для аренды необходимы паспорт, водительское удостоверение и кредитная карта для внесения депозита.</p>
            </div>
            
            <div className="bg-card p-6 rounded-md">
              <h3 className="text-xl font-medium mb-3">Можно ли отменить бронирование?</h3>
              <p className="text-muted-foreground">Да, бронирование можно отменить за 24 часа до начала аренды без штрафа. При более поздней отмене взимается 30% от стоимости аренды.</p>
            </div>
            
            <div className="bg-card p-6 rounded-md">
              <h3 className="text-xl font-medium mb-3">Включена ли страховка в стоимость?</h3>
              <p className="text-muted-foreground">Базовая страховка включена в стоимость аренды. Дополнительные опции страхования доступны за отдельную плату.</p>
            </div>
          </div>
        </div>
      </section>
      
      {/* Footer */}
      <footer className="py-12 bg-background border-t">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h3 className="text-xl font-playfair font-bold mb-4">MEOWVEST</h3>
              <p className="text-muted-foreground mb-6">Премиальный сервис аренды автомобилей с возможностью 3D просмотра</p>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Навигация</h3>
              <ul className="space-y-2">
                <li><a href="/" className="text-muted-foreground hover:text-primary transition">Главная</a></li>
                <li><a href="/catalog" className="text-muted-foreground hover:text-primary transition">Каталог</a></li>
                <li><a href="/about" className="text-muted-foreground hover:text-primary transition">О нас</a></li>
                <li><a href="/contact" className="text-muted-foreground hover:text-primary transition">Контакты</a></li>
              </ul>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Контакты</h3>
              <ul className="space-y-2 text-muted-foreground">
                <li>Москва, ул. Автомобильная, 123</li>
                <li>+7 (495) 123-45-67</li>
                <li>info@meowvest.ru</li>
              </ul>
            </div>
            
            <div>
              <h3 className="font-medium mb-4">Подписаться на новости</h3>
              <div className="flex">
                <Input 
                  type="email" 
                  placeholder="Ваш email" 
                  className="rounded-r-none"
                />
                <Button variant="default" className="rounded-l-none">OK</Button>
              </div>
            </div>
          </div>
          
          <div className="border-t mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p className="text-muted-foreground text-sm">© {new Date().getFullYear()} MEOWVEST. Все права защищены.</p>
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

export default Contact;
