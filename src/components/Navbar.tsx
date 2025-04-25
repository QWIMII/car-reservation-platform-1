import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { Menu, X } from 'lucide-react';

const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <header 
      className={`fixed w-full top-0 left-0 z-50 transition-all duration-300 ${
        isScrolled ? 'bg-background/90 backdrop-blur-sm py-4 shadow-sm' : 'bg-transparent py-6'
      }`}
    >
      <div className="container mx-auto px-4 flex items-center justify-between">
        <Link to="/" className="flex items-center space-x-2">
          <span className="text-xl font-playfair font-bold">АВТОПАРК</span>
        </Link>

        {/* Desktop Navigation */}
        <nav className="hidden md:flex items-center space-x-8">
          <Link to="/" className="text-sm uppercase tracking-wide hover:text-primary/80 transition">
            Главная
          </Link>
          <Link to="/catalog" className="text-sm uppercase tracking-wide hover:text-primary/80 transition">
            Каталог
          </Link>
          <Link to="/about" className="text-sm uppercase tracking-wide hover:text-primary/80 transition">
            О нас
          </Link>
          <Link to="/contact" className="text-sm uppercase tracking-wide hover:text-primary/80 transition">
            Контакты
          </Link>
        </nav>

        <div className="hidden md:flex items-center space-x-4">
          <Button variant="outline" size="sm" className="rounded-none border-primary/20 hover:border-primary/60">
            Забронировать
          </Button>
        </div>

        {/* Mobile Menu Button */}
        <button 
          className="md:hidden"
          onClick={() => setIsMenuOpen(!isMenuOpen)}
        >
          {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
        </button>
      </div>

      {/* Mobile Menu */}
      {isMenuOpen && (
        <div className="md:hidden absolute top-full left-0 w-full bg-background/95 backdrop-blur-sm border-b border-border animate-fade-in">
          <div className="container mx-auto px-4 py-4 flex flex-col space-y-4">
            <Link 
              to="/" 
              className="py-2 px-4 hover:bg-secondary/50 rounded transition"
              onClick={() => setIsMenuOpen(false)}
            >
              Главная
            </Link>
            <Link 
              to="/catalog" 
              className="py-2 px-4 hover:bg-secondary/50 rounded transition"
              onClick={() => setIsMenuOpen(false)}
            >
              Каталог
            </Link>
            <Link 
              to="/about" 
              className="py-2 px-4 hover:bg-secondary/50 rounded transition"
              onClick={() => setIsMenuOpen(false)}
            >
              О нас
            </Link>
            <Link 
              to="/contact" 
              className="py-2 px-4 hover:bg-secondary/50 rounded transition"
              onClick={() => setIsMenuOpen(false)}
            >
              Контакты
            </Link>
            <Button variant="default" size="sm" className="w-full mt-2">
              Забронировать
            </Button>
          </div>
        </div>
      )}
    </header>
  );
};

export default Navbar;
