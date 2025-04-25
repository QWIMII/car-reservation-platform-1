import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Car3d } from '@/types/car';

interface CarCardProps {
  car: Car3d;
}

const CarCard = ({ car }: CarCardProps) => {
  const [isHovered, setIsHovered] = useState(false);

  return (
    <Link 
      to={`/car/${car.id}`}
      className="car-card block"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      <div className="relative aspect-[16/10] overflow-hidden rounded-t-lg">
        <img 
          src={car.imageUrl} 
          alt={car.name} 
          className={`w-full h-full object-cover transition-transform duration-700 ${
            isHovered ? 'scale-110' : 'scale-100'
          }`}
        />
        
        {car.isNew && (
          <Badge className="absolute top-4 left-4 bg-white text-black font-medium px-3 py-1 rounded-sm">
            Новинка
          </Badge>
        )}
        
        {car.is3dReady && (
          <Badge variant="outline" className="absolute top-4 right-4 bg-white/80 backdrop-blur-sm text-black font-medium px-3 py-1 rounded-sm">
            3D Просмотр
          </Badge>
        )}
      </div>
      
      <div className="p-5 bg-card border border-t-0 rounded-b-lg">
        <div className="flex justify-between items-start mb-3">
          <h3 className="font-playfair text-xl font-medium">{car.name}</h3>
          <p className="text-lg font-medium">{car.pricePerDay} ₽/день</p>
        </div>
        
        <div className="flex items-center text-sm text-muted-foreground mb-4">
          <span>{car.year}</span>
          <span className="mx-2">•</span>
          <span>{car.transmission}</span>
          <span className="mx-2">•</span>
          <span>{car.enginePower} л.с.</span>
        </div>
        
        <a href={`/car/${car.id}/book`} onClick={(e) => {
          e.preventDefault();
          // Проверяем, авторизован ли пользователь
          const isLoggedIn = localStorage.getItem('user_id');
          if (isLoggedIn) {
            // Если авторизован, переходим на страницу бронирования
            window.location.href = `/car/${car.id}/book`;
          } else {
            // Если не авторизован, сохраняем URL для редиректа после логина
            localStorage.setItem('booking_redirect', `/car/${car.id}/book`);
            window.location.href = '/login';
          }
        }} className="w-full">
          <Button variant="outline" className="w-full rounded-sm">
            Забронировать
          </Button>
        </a>
      </div>
    </Link>
  );
};

export default CarCard;
