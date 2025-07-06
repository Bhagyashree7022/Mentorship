package com.dkte.pizzashop.menu;

import java.sql.SQLException;
import java.util.List;
import java.util.Scanner;

import com.dkte.pizzashop.dao.PizzaDAO;
import com.dkte.pizzashop.entities.Admin;
import com.dkte.pizzashop.entities.Customer;
import com.dkte.pizzashop.entities.Pizza;

public class PizzaMenu {
	public static int menu(Scanner sc) {
		System.out.println("******Welcome  to Pizza menu ******* ");
		System.out.println("0. leave ");
		System.out.println("1. Veg ");
		System.out.println("2. Non-Veg ");
		System.out.println("3. Garlic Bread ");
		System.out.println("4. Drinks ");
		System.out.println("***************************************");
		System.out.println("Enter your Choice := ");
		int choice = sc.nextInt();
		return choice;
	}

	private static void displayVegPizza(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.adminGetMenu(category);
			pizzaList.forEach(p -> p.displayPizza());

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayNonVegPizza(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.adminGetMenu(category);
			pizzaList.forEach(p -> p.displayPizza());

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayGarlicBread(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.adminGetMenu(category);
			pizzaList.forEach(p -> p.displayBread());

		} catch (SQLException e) {
			e.printStackTrace();
		}

	}

	private static void displayDrinks(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.customerGetMenu(category);
			pizzaList.forEach(p -> p.displayDrink());

		} catch (SQLException e) {
			e.printStackTrace();
		}

	}

	private static void displayVegPizzaC(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.customerGetMenu(category);
			pizzaList.forEach(p -> p.displayPizza());

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayNonVegPizzaC(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.customerGetMenu(category);
			pizzaList.forEach(p -> p.displayPizza());

		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	private static void displayGarlicBreadC(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.customerGetMenu(category);
			pizzaList.forEach(p -> p.displayBread());

		} catch (SQLException e) {
			e.printStackTrace();
		}

	}

	private static void displayDrinksC(String category) {
		try (PizzaDAO pizzaDAO = new PizzaDAO()) {
			List<Pizza> pizzaList = pizzaDAO.customerGetMenu(category);
			pizzaList.forEach(p -> p.displayDrink());

		} catch (SQLException e) {
			e.printStackTrace();
		}

	}

	public static void AdmindisplayPizza(Scanner sc, Admin admin) {
		int choice = 1;
		while ((choice = menu(sc)) != 0) {
			switch (choice) {
			case 1:
				displayVegPizza("veg");
				break;

			case 2:
				displayNonVegPizza("non-veg");
				break;

			case 3:
				displayGarlicBread("garlicbread");
				break;
			case 4:
				displayDrinks("drink");
				break;
			default:
				System.out.println("Wrong choice!..");
			}
		}
		System.out.println("You Leaved from menu....");
	}

	public static void CustomerdisplayPizza(Scanner sc, Customer customer) {
		int choice = 1;
		while ((choice = menu(sc)) != 0) {
			switch (choice) {
			case 1:
				displayVegPizzaC("veg");
				break;

			case 2:
				displayNonVegPizzaC("non-veg");
				break;

			case 3:
				displayGarlicBreadC("garlicbread");
				break;
			case 4:
				displayDrinksC("drink");
				break;
			default:
				System.out.println("Wrong choice!...");
			}
		}
		System.out.println("You Leaved from menu....");
	}

}
