export interface User {
  id: string;
  firstName: string;
  lastName: string;
  email: string;
  phone: string;
  address: string;
  avatar?: string;
  createdAt: Date;
  role: 'user' | 'admin';
}

export const userData: User = {
  id: "u1",
  firstName: "Иван",
  lastName: "Петров",
  email: "ivan@example.com",
  phone: "+7 (999) 123-45-67",
  address: "г. Москва, ул. Примерная, д. 123, кв. 45",
  avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
  createdAt: new Date("2023-01-15"),
  role: "user"
};
