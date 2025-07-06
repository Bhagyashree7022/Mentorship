package com.dkte.pizzashop.menu;

import java.sql.SQLException;
import java.util.List;
import java.util.Scanner;

import com.dkte.pizzashop.dao.CustomerDAO;
import com.dkte.pizzashop.dao.OrdersDAO;
import com.dkte.pizzashop.dao.PizzaDAO;
import com.dkte.pizzashop.entities.Admin;
import com.dkte.pizzashop.entities.Customer;
import com.dkte.pizzashop.entities.Order;
import com.dkte.pizzashop.entities.Pizza;

public class AdminMenu {

	public static int menu(Scanner sc) {
		System.out.println("*******WELCOME ADMIN ************");
		System.out.println("0.Logged out ");
		System.out.println("1.Add New Pizza");
		System.out.println("2.Update Price");
		System.out.println("3.Delete Pizza");
		System.out.println("4.Display All Pizza menu ");
		System.out.println("5.Display All Customers");
		System.out.println("6.Display all orders");
		System.out.println("7.Calculate Total Profit");
		System.out.println("********************************");
		System.out.println("Enter your choice := ");
		return sc.nextInt();
	}

	private static void addNewPizza(Scanner sc) {
		Pizza pizza = new Pizza();
		pizza.acceptPizza(sc);
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			pizzaDAO.addPizza(pizza);
			System.out.println("Pizza Added successfully..");
		} catch (SQLException e) {
			e.printStackTrace();
		}

	}

	private static void updatePizzaPrize(Scanner sc) {
		System.out.println("Enter mid := ");
		int mid = sc.nextInt();
		System.out.println("Enter price := ");
		double price = sc.nextDouble();

		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			pizzaDAO.updatePizzaPrice(mid, price);
			System.out.println("Prize Updated");
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void deletePizza(Scanner sc) {
		System.out.println("Enter mid := ");
		int mid = sc.nextInt();
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			if (pizzaDAO.deletePizza(mid) != 0)
				System.out.println("Pizza deleted ");
			else
				System.out.println("Error in Pizza deleted ");

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayAllOrders() {
		try (OrdersDAO ordersDAO = new OrdersDAO()) {
			try {
				List<Order> ordersList = ordersDAO.getAllOrders();
				ordersList.forEach(o -> System.out.println(o));

			} catch (Exception e) {

				e.printStackTrace();
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayAllCustomers() {
		try (CustomerDAO customerDAO = new CustomerDAO()) {
			List<Customer> customerList = customerDAO.getAllCustomer();
			System.out.println(" name     email               password  mobile number");
			customerList.forEach(c -> c.display());

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	public static void calculateProfit() {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			double profit = pizzaDAO.calculateProfit();
			System.out.println("Total profit is := " + profit);
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	public static void AdminMenu(Scanner sc, Admin admin) {
		int choice = 1;
		while ((choice = menu(sc)) != 0) {
			switch (choice) {
			case 1:
				addNewPizza(sc);
				break;
			case 2:
				updatePizzaPrize(sc);
				break;
			case 3:
				deletePizza(sc);
				break;
			case 4:
				PizzaMenu.AdmindisplayPizza(sc, admin);
				break;
			case 5:
				displayAllCustomers();
				break;
			case 6:
				displayAllOrders();
				break;
			case 7:
				calculateProfit();
				break;
			default:
				System.out.println("Wrong choice !...");
			}

		}
		System.out.println("Admin logged out Sucessfully");
	}

}
