import { useState } from 'react';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { X, User } from 'lucide-react';

interface AuthModalProps {
  trigger?: React.ReactNode;
}

const AuthModal = ({ trigger }: AuthModalProps) => {
  const [open, setOpen] = useState(false);
  const [activeTab, setActiveTab] = useState('login');

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    // Логика авторизации
    console.log('Логин пользователя');
    setOpen(false);
  };

  const handleRegister = (e: React.FormEvent) => {
    e.preventDefault();
    // Логика регистрации
    console.log('Регистрация пользователя');
    setOpen(false);
  };

  return (
    <Dialog open={open} onOpenChange={setOpen}>
      <DialogTrigger asChild>
        {trigger || (
          <Button variant="outline" size="sm" className="gap-2">
            <User className="h-4 w-4" />
            <span>Войти</span>
          </Button>
        )}
      </DialogTrigger>
      <DialogContent className="sm:max-w-[425px] p-0 overflow-hidden">
        <button 
          onClick={() => setOpen(false)} 
          className="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none"
        >
          <X className="h-4 w-4" />
          <span className="sr-only">Закрыть</span>
        </button>
        
        <Tabs defaultValue={activeTab} onValueChange={setActiveTab} className="w-full">
          <div className="border-b">
            <TabsList className="w-full grid grid-cols-2 rounded-none h-16">
              <TabsTrigger 
                value="login" 
                className="data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-none"
              >
                Вход
              </TabsTrigger>
              <TabsTrigger 
                value="register" 
                className="data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-none"
              >
                Регистрация
              </TabsTrigger>
            </TabsList>
          </div>
          
          <TabsContent value="login" className="p-6">
            <form onSubmit={handleLogin}>
              <div className="space-y-4">
                <div className="space-y-2">
                  <Label htmlFor="email">Email</Label>
                  <Input id="email" type="email" placeholder="your@email.com" required />
                </div>
                <div className="space-y-2">
                  <div className="flex items-center justify-between">
                    <Label htmlFor="password">Пароль</Label>
                    <Button variant="link" className="p-0 h-auto text-xs">
                      Забыли пароль?
                    </Button>
                  </div>
                  <Input id="password" type="password" required />
                </div>
                <Button type="submit" className="w-full">
                  Войти
                </Button>
              </div>
            </form>
          </TabsContent>
          
          <TabsContent value="register" className="p-6">
            <form onSubmit={handleRegister}>
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="firstName">Имя</Label>
                    <Input id="firstName" placeholder="Иван" required />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="lastName">Фамилия</Label>
                    <Input id="lastName" placeholder="Иванов" required />
                  </div>
                </div>
                <div className="space-y-2">
                  <Label htmlFor="registerEmail">Email</Label>
                  <Input id="registerEmail" type="email" placeholder="your@email.com" required />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="phone">Телефон</Label>
                  <Input id="phone" type="tel" placeholder="+7 (999) 123-45-67" />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="registerPassword">Пароль</Label>
                  <Input id="registerPassword" type="password" required />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="confirmPassword">Подтвердите пароль</Label>
                  <Input id="confirmPassword" type="password" required />
                </div>
                <Button type="submit" className="w-full">
                  Зарегистрироваться
                </Button>
              </div>
            </form>
          </TabsContent>
        </Tabs>
      </DialogContent>
    </Dialog>
  );
};

export default AuthModal;
