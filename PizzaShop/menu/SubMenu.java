package com.dkte.pizzashop.menu;

import java.sql.SQLException;
import java.util.List;
import java.util.Scanner;

import com.dkte.pizzashop.dao.OrdersDAO;
import com.dkte.pizzashop.entities.Customer;
import com.dkte.pizzashop.entities.Pizza;

public class SubMenu {
	public static int menu(Scanner sc, Customer customer) {
		System.out.println("******Welcome  " + customer.getName() + "******* ");
		System.out.println("0. Logout ");
		System.out.println("1. Pizza Menu ");
		System.out.println("2. Order a Pizza ");
		System.out.println("3. Order History ");
		System.out.println("***************************************");
		System.out.println("Enter your Choice := ");
		int choice = sc.nextInt();
		return choice;
	}

	private static void orderPizza(Scanner sc, int cid) throws SQLException {
		System.out.println("Enter menu id := ");
		int mid = sc.nextInt();
		try (OrdersDAO ordersDAO = new OrdersDAO()) {
			ordersDAO.orderPizza(cid, mid);
			System.out.println("order placed..");
		}
	}

	private static void orderHistory(Scanner sc, int cid) throws SQLException {
		try (OrdersDAO ordersDAO = new OrdersDAO()) {
			List<Pizza> list = ordersDAO.orderHistory(cid);
			list.forEach(p -> p.displayPizzaC());

		}
	}

	public static void SubMenu(Scanner sc, Customer customer) {

		int choice = 1, id = 0;
		while ((choice = menu(sc, customer)) != 0) {
			switch (choice) {
			case 1:
				PizzaMenu.CustomerdisplayPizza(sc, customer);
				break;

			case 2:
				id = customer.getId();
				try {
					orderPizza(sc, id);
				} catch (SQLException e) {
					e.printStackTrace();
				}
				break;

			case 3:
				System.out.println("Order history ");
				id = customer.getId();
				try {
					orderHistory(sc, id);
				} catch (SQLException e) {
					e.printStackTrace();
				}
				break;

			default:
				System.out.println("Wrong choice !...");
			}
		}
		System.out.println("You logged out Successfully....");
	}

}
