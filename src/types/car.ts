export interface Car3d {
  id: string;
  name: string;
  brand: string;
  model: string;
  year: number;
  transmission: 'Автомат' | 'Механика';
  enginePower: number;
  fuelType: 'Бензин' | 'Дизель' | 'Электро';
  seats: number;
  pricePerDay: number;
  deposit: number;
  description: string;
  features: string[];
  imageUrl: string;
  galleryImages: string[];
  modelUrl?: string; // URL для 3D модели
  is3dReady: boolean;
  isNew: boolean;
  isAvailable: boolean;
  category: 'Спорткар' | 'Премиум' | 'Бизнес' | 'Внедорожник' | 'Эконом';
}

export const carsData: Car3d[] = [
  {
    id: "1",
    name: "Mercedes-Benz S-Class",
    brand: "Mercedes-Benz",
    model: "S-Class",
    year: 2023,
    transmission: "Автомат",
    enginePower: 435,
    fuelType: "Бензин",
    seats: 5,
    pricePerDay: 15000,
    deposit: 50000,
    description: "Флагманский седан Mercedes-Benz, воплощающий роскошь и инновации.",
    features: ["Панорамная крыша", "Массаж сидений", "Система ночного видения", "Адаптивный круиз-контроль"],
    imageUrl: "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
    galleryImages: [
      "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
      "https://images.unsplash.com/photo-1609521263047-f8f205293f24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
    ],
    modelUrl: "/models/mercedes-s-class.glb",
    is3dReady: true,
    isNew: true,
    isAvailable: true,
    category: "Премиум"
  },
  {
    id: "2",
    name: "BMW 7 Series",
    brand: "BMW",
    model: "7 Series",
    year: 2022,
    transmission: "Автомат",
    enginePower: 530,
    fuelType: "Бензин",
    seats: 5,
    pricePerDay: 14000,
    deposit: 45000,
    description: "Представительский седан BMW с передовыми технологиями и безупречным комфортом.",
    features: ["Лазерные фары", "Система автономного вождения", "Премиальная аудиосистема", "Четырехзонный климат-контроль"],
    imageUrl: "https://images.unsplash.com/photo-1556189250-72ba954cfc2b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
    galleryImages: [
      "https://images.unsplash.com/photo-1556189250-72ba954cfc2b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
      "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80"
    ],
    modelUrl: "/models/bmw-7-series.glb",
    is3dReady: true,
    isNew: false,
    isAvailable: true,
    category: "Премиум"
  },
  {
    id: "3",
    name: "Porsche 911",
    brand: "Porsche",
    model: "911",
    year: 2023,
    transmission: "Автомат",
    enginePower: 450,
    fuelType: "Бензин",
    seats: 2,
    pricePerDay: 20000,
    deposit: 70000,
    description: "Легендарный спортивный автомобиль с безупречной управляемостью и динамикой.",
    features: ["Спортивная выхлопная система", "Керамические тормоза", "Адаптивная подвеска", "Спортивные сиденья"],
    imageUrl: "https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
    galleryImages: [
      "https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80",
      "https://images.unsplash.com/photo-1580274455191-1c62238fa333?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80"
    ],
    modelUrl: "/models/porsche-911.glb",
    is3dReady: true,
    isNew: true,
    isAvailable: true,
    category: "Спорткар"
  }
];
