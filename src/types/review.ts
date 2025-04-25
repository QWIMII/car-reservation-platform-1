export interface Review {
  id: string;
  userId: string;
  carId: string;
  rating: number;
  comment: string;
  createdAt: Date;
  userName: string;
  userAvatar?: string;
}

export const reviewsData: Review[] = [
  {
    id: "rev1",
    userId: "u1",
    carId: "1",
    rating: 5,
    comment: "Превосходный автомобиль! Комфорт и динамика на высшем уровне. Определенно буду арендовать снова.",
    createdAt: new Date("2023-09-20"),
    userName: "Иван П.",
    userAvatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
  },
  {
    id: "rev2",
    userId: "u2",
    carId: "1",
    rating: 4,
    comment: "Отличный автомобиль, очень удобный и мощный. Единственный минус - расход топлива выше ожидаемого.",
    createdAt: new Date("2023-08-15"),
    userName: "Алексей К.",
    userAvatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
  },
  {
    id: "rev3",
    userId: "u3",
    carId: "2",
    rating: 5,
    comment: "Идеальный выбор для бизнес-поездок. Презентабельный внешний вид и комфортный салон.",
    createdAt: new Date("2023-10-05"),
    userName: "Мария С.",
    userAvatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
  }
];
