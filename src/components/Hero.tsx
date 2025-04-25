import { Button } from '@/components/ui/button';
import { ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';

const Hero = () => {
  return (
    <section className="relative min-h-screen flex items-center overflow-hidden">
      {/* Background Image */}
      <div 
        className="absolute inset-0 bg-black z-0" 
        style={{
          backgroundImage: 'url(https://images.unsplash.com/photo-1592853598064-a79ea7913e05?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80)',
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          filter: 'brightness(0.5)'
        }}
      />

      <div className="container mx-auto px-4 relative z-10">
        <div className="max-w-3xl">
          <h1 className="animated-title text-4xl md:text-5xl lg:text-7xl font-playfair font-medium text-white mb-6">
            <span>Премиальный</span>{' '}
            <span>автопарк</span>{' '}
            <span>для</span>{' '}
            <span>вашего</span>{' '}
            <span>удовольствия</span>
          </h1>
          
          <p className="text-white/80 text-lg md:text-xl mb-8 animate-fade-in" style={{ animationDelay: '0.6s' }}>
            Широкий выбор престижных автомобилей с возможностью изучить каждую деталь в 3D режиме перед бронированием
          </p>
          
          <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4 animate-fade-in" style={{ animationDelay: '0.8s' }}>
            <Button asChild size="lg" className="rounded-none text-base px-8 py-6">
              <Link to="/catalog">
                Выбрать автомобиль
                <ArrowRight className="ml-2 h-5 w-5" />
              </Link>
            </Button>
            <Button asChild variant="default" size="lg" className="bg-black text-white border border-white rounded-none text-base px-8 py-6 hover:bg-gray-900">
              <Link to="/about">
                О нашем автопарке
              </Link>
            </Button>
          </div>
        </div>
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex flex-col items-center animate-pulse">
        <span className="text-white/60 text-sm mb-2 uppercase tracking-widest">Прокрутите вниз</span>
        <svg className="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </div>
    </section>
  );
};

export default Hero;
