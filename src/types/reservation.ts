import { Car3d } from './car';

export interface Reservation {
  id: string;
  userId: string;
  car: Car3d;
  startDate: Date;
  endDate: Date;
  totalPrice: number;
  status: 'active' | 'completed' | 'canceled';
  paymentStatus: 'pending' | 'paid' | 'refunded';
  createdAt: Date;
  updatedAt: Date;
}

// Импортируем данные авто из car.ts
import { carsData } from './car';

export const reservationsData: Reservation[] = [
  {
    id: "res1",
    userId: "u1",
    car: carsData[0],
    startDate: new Date("2023-09-15"),
    endDate: new Date("2023-09-18"),
    totalPrice: 45000,
    status: "completed",
    paymentStatus: "paid",
    createdAt: new Date("2023-09-10"),
    updatedAt: new Date("2023-09-10")
  },
  {
    id: "res2",
    userId: "u1",
    car: carsData[2],
    startDate: new Date("2023-11-20"),
    endDate: new Date("2023-11-25"),
    totalPrice: 100000,
    status: "active",
    paymentStatus: "paid",
    createdAt: new Date("2023-11-15"),
    updatedAt: new Date("2023-11-15")
  }
];
