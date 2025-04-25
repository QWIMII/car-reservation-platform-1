import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Separator } from '@/components/ui/separator';
import { 
  User, 
  CalendarClock, 
  Car, 
  CreditCard, 
  Settings, 
  LogOut, 
  Edit, 
  Clock,
  UserCircle,
  Phone,
  Mail,
  Check,
  Map
} from 'lucide-react';
import Navbar from '@/components/Navbar';
import { reservationsData } from '@/types/reservation';
import { userData } from '@/types/user';

const Profile = () => {
  const [user, setUser] = useState(userData);
  const [isEditing, setIsEditing] = useState(false);
  
  const handleSaveProfile = () => {
    setIsEditing(false);
    // Логика сохранения данных профиля
    console.log('Профиль сохранен');
  };

  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      
      <div className="container mx-auto px-4 py-32">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Sidebar */}
          <div className="lg:col-span-1">
            <div className="bg-secondary/10 p-6 rounded-md sticky top-32">
              <div className="flex items-center space-x-4 mb-8">
                <Avatar className="h-16 w-16">
                  <AvatarImage src={user.avatar} alt={user.firstName} />
                  <AvatarFallback>{user.firstName[0]}{user.lastName[0]}</AvatarFallback>
                </Avatar>
                <div>
                  <h2 className="text-xl font-medium">{user.firstName} {user.lastName}</h2>
                  <p className="text-muted-foreground text-sm">{user.email}</p>
                </div>
              </div>
              
              <Tabs defaultValue="profile" className="w-full">
                <TabsList className="grid grid-cols-1 w-full bg-transparent h-auto gap-2">
                  <TabsTrigger
                    value="profile"
                    className="justify-start py-3 px-4 data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-md"
                  >
                    <UserCircle className="mr-2 h-5 w-5" />
                    Личные данные
                  </TabsTrigger>
                  <TabsTrigger
                    value="reservations"
                    className="justify-start py-3 px-4 data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-md"
                  >
                    <CalendarClock className="mr-2 h-5 w-5" />
                    Мои бронирования
                  </TabsTrigger>
                  <TabsTrigger
                    value="favorites"
                    className="justify-start py-3 px-4 data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-md"
                  >
                    <Car className="mr-2 h-5 w-5" />
                    Избранные автомобили
                  </TabsTrigger>
                  <TabsTrigger
                    value="payments"
                    className="justify-start py-3 px-4 data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-md"
                  >
                    <CreditCard className="mr-2 h-5 w-5" />
                    Платежная информация
                  </TabsTrigger>
                  <TabsTrigger
                    value="settings"
                    className="justify-start py-3 px-4 data-[state=active]:bg-secondary/20 data-[state=active]:shadow-none rounded-md"
                  >
                    <Settings className="mr-2 h-5 w-5" />
                    Настройки
                  </TabsTrigger>
                </TabsList>
              </Tabs>
              
              <Separator className="my-6" />
              
              <Button variant="ghost" className="w-full justify-start text-muted-foreground">
                <LogOut className="mr-2 h-5 w-5" />
                Выйти из аккаунта
              </Button>
            </div>
          </div>
          
          {/* Content */}
          <div className="lg:col-span-2">
            <Tabs defaultValue="profile">
              <TabsContent value="profile" className="mt-0">
                <Card>
                  <CardHeader className="flex flex-row items-center justify-between">
                    <div>
                      <CardTitle>Личные данные</CardTitle>
                      <CardDescription>
                        Управляйте вашей персональной информацией
                      </CardDescription>
                    </div>
                    {!isEditing ? (
                      <Button variant="outline" onClick={() => setIsEditing(true)}>
                        <Edit className="mr-2 h-4 w-4" />
                        Редактировать
                      </Button>
                    ) : (
                      <Button onClick={handleSaveProfile}>
                        <Check className="mr-2 h-4 w-4" />
                        Сохранить
                      </Button>
                    )}
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-6">
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div className="space-y-2">
                          <Label>Имя</Label>
                          {isEditing ? (
                            <Input 
                              defaultValue={user.firstName} 
                              onChange={(e) => setUser({...user, firstName: e.target.value})}
                            />
                          ) : (
                            <Value>{user.firstName}</Value>
                          )}
                        </div>
                        <div className="space-y-2">
                          <Label>Фамилия</Label>
                          {isEditing ? (
                            <Input 
                              defaultValue={user.lastName} 
                              onChange={(e) => setUser({...user, lastName: e.target.value})}
                            />
                          ) : (
                            <Value>{user.lastName}</Value>
                          )}
                        </div>
                      </div>
                      
                      <div className="space-y-2">
                        <Label>Email</Label>
                        <div className="flex items-center">
                          <Mail className="h-4 w-4 mr-2 text-muted-foreground" />
                          {isEditing ? (
                            <Input 
                              defaultValue={user.email} 
                              onChange={(e) => setUser({...user, email: e.target.value})}
                            />
                          ) : (
                            <Value>{user.email}</Value>
                          )}
                        </div>
                      </div>
                      
                      <div className="space-y-2">
                        <Label>Телефон</Label>
                        <div className="flex items-center">
                          <Phone className="h-4 w-4 mr-2 text-muted-foreground" />
                          {isEditing ? (
                            <Input 
                              defaultValue={user.phone} 
                              onChange={(e) => setUser({...user, phone: e.target.value})}
                            />
                          ) : (
                            <Value>{user.phone}</Value>
                          )}
                        </div>
                      </div>
                      
                      <div className="space-y-2">
                        <Label>Адрес</Label>
                        <div className="flex items-start">
                          <Map className="h-4 w-4 mr-2 text-muted-foreground mt-1" />
                          {isEditing ? (
                            <Input 
                              defaultValue={user.address} 
                              onChange={(e) => setUser({...user, address: e.target.value})}
                            />
                          ) : (
                            <Value>{user.address}</Value>
                          )}
                        </div>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </TabsContent>
              
              <TabsContent value="reservations" className="mt-0">
                <Card>
                  <CardHeader>
                    <CardTitle>Мои бронирования</CardTitle>
                    <CardDescription>История и текущие бронирования автомобилей</CardDescription>
                  </CardHeader>
                  <CardContent>
                    {reservationsData.length > 0 ? (
                      <div className="space-y-6">
                        {reservationsData.map((reservation) => (
                          <div key={reservation.id} className="bg-secondary/5 rounded-md p-4 border">
                            <div className="flex flex-col md:flex-row justify-between mb-3">
                              <div>
                                <h3 className="font-medium">{reservation.car.brand} {reservation.car.model}</h3>
                                <p className="text-sm text-muted-foreground">№ бронирования: {reservation.id.toUpperCase()}</p>
                              </div>
                              <div className="mt-2 md:mt-0">
                                <Badge 
                                  variant={
                                    reservation.status === 'active' ? 'default' : 
                                    reservation.status === 'completed' ? 'secondary' : 
                                    'destructive'
                                  }
                                >
                                  {reservation.status === 'active' ? 'Активно' : 
                                   reservation.status === 'completed' ? 'Завершено' : 
                                   'Отменено'}
                                </Badge>
                              </div>
                            </div>
                            
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                              <div className="flex items-center">
                                <CalendarClock className="h-4 w-4 mr-2 text-muted-foreground" />
                                <p className="text-sm">
                                  {new Date(reservation.startDate).toLocaleDateString('ru-RU')} - 
                                  {new Date(reservation.endDate).toLocaleDateString('ru-RU')}
                                </p>
                              </div>
                              
                              <div className="flex items-center">
                                <Clock className="h-4 w-4 mr-2 text-muted-foreground" />
                                <p className="text-sm">
                                  Продолжительность: {
                                    Math.ceil((new Date(reservation.endDate).getTime() - 
                                    new Date(reservation.startDate).getTime()) / (1000 * 60 * 60 * 24))
                                  } дней
                                </p>
                              </div>
                            </div>
                            
                            <div className="flex flex-col md:flex-row justify-between items-start md:items-center">
                              <p className="font-medium">
                                Итого: {reservation.totalPrice.toLocaleString('ru-RU')} ₽
                              </p>
                              
                              <div className="mt-3 md:mt-0 space-x-2">
                                <Button variant="outline" size="sm">
                                  Подробнее
                                </Button>
                                {reservation.status === 'active' && (
                                  <Button variant="destructive" size="sm">
                                    Отменить
                                  </Button>
                                )}
                              </div>
                            </div>
                          </div>
                        ))}
                      </div>
                    ) : (
                      <div className="text-center py-8">
                        <CalendarClock className="mx-auto h-12 w-12 text-muted-foreground/30 mb-4" />
                        <h3 className="text-lg font-medium mb-2">У вас пока нет бронирований</h3>
                        <p className="text-muted-foreground mb-6">
                          Начните с выбора автомобиля в нашем каталоге
                        </p>
                        <Button asChild>
                          <Link to="/catalog">Перейти в каталог</Link>
                        </Button>
                      </div>
                    )}
                  </CardContent>
                </Card>
              </TabsContent>
              
              <TabsContent value="favorites" className="mt-0">
                <Card>
                  <CardHeader>
                    <CardTitle>Избранные автомобили</CardTitle>
                    <CardDescription>Автомобили, которые вы отметили как избранные</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="text-center py-8">
                      <Car className="mx-auto h-12 w-12 text-muted-foreground/30 mb-4" />
                      <h3 className="text-lg font-medium mb-2">У вас пока нет избранных автомобилей</h3>
                      <p className="text-muted-foreground mb-6">
                        Добавляйте автомобили в избранное, чтобы быстро к ним вернуться
                      </p>
                      <Button asChild>
                        <Link to="/catalog">Перейти в каталог</Link>
                      </Button>
                    </div>
                  </CardContent>
                </Card>
              </TabsContent>
              
              <TabsContent value="payments" className="mt-0">
                <Card>
                  <CardHeader>
                    <CardTitle>Платежная информация</CardTitle>
                    <CardDescription>Управляйте вашими способами оплаты и платежными данными</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="text-center py-8">
                      <CreditCard className="mx-auto h-12 w-12 text-muted-foreground/30 mb-4" />
                      <h3 className="text-lg font-medium mb-2">У вас пока нет сохраненных способов оплаты</h3>
                      <p className="text-muted-foreground mb-6">
                        Добавьте платежную карту для более быстрого оформления бронирования
                      </p>
                      <Button>Добавить способ оплаты</Button>
                    </div>
                  </CardContent>
                </Card>
              </TabsContent>
              
              <TabsContent value="settings" className="mt-0">
                <Card>
                  <CardHeader>
                    <CardTitle>Настройки</CardTitle>
                    <CardDescription>Управляйте настройками вашего аккаунта</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-6">
                      <div className="space-y-2">
                        <h3 className="font-medium">Безопасность</h3>
                        <Button variant="outline">Изменить пароль</Button>
                      </div>
                      
                      <Separator />
                      
                      <div className="space-y-2">
                        <h3 className="font-medium">Уведомления</h3>
                        <div className="space-y-4">
                          <div className="flex items-center justify-between">
                            <div>
                              <p>Email-уведомления</p>
                              <p className="text-sm text-muted-foreground">Получать уведомления о бронированиях на email</p>
                            </div>
                            <Toggle defaultChecked />
                          </div>
                          
                          <div className="flex items-center justify-between">
                            <div>
                              <p>SMS-уведомления</p>
                              <p className="text-sm text-muted-foreground">Получать SMS о статусе бронирования</p>
                            </div>
                            <Toggle />
                          </div>
                        </div>
                      </div>
                      
                      <Separator />
                      
                      <div className="space-y-2">
                        <h3 className="font-medium text-destructive">Опасная зона</h3>
                        <p className="text-sm text-muted-foreground">
                          После удаления аккаунта все ваши данные будут удалены без возможности восстановления
                        </p>
                        <Button variant="destructive">Удалить аккаунт</Button>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </TabsContent>
            </Tabs>
          </div>
        </div>
      </div>
    </div>
  );
};

// Вспомогательные компоненты
const Label = ({ children }: { children: React.ReactNode }) => (
  <p className="text-sm font-medium text-muted-foreground">{children}</p>
);

const Value = ({ children }: { children: React.ReactNode }) => (
  <p className="font-medium">{children}</p>
);

const Toggle = ({ defaultChecked = false }: { defaultChecked?: boolean }) => (
  <div className="relative inline-flex h-6 w-11 items-center rounded-full bg-muted transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background data-[state=checked]:bg-primary">
    <div className={`pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform ${defaultChecked ? 'translate-x-5' : 'translate-x-0'}`} />
  </div>
);

export default Profile;
