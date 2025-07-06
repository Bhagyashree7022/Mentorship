package com.dkte.pizzashop.menu;

import java.sql.SQLException;
import java.util.Scanner;

import com.dkte.pizzashop.dao.AdminDAO;
import com.dkte.pizzashop.dao.CustomerDAO;
import com.dkte.pizzashop.entities.Admin;
import com.dkte.pizzashop.entities.Customer;

public class MainMenu {

	private static int menu(Scanner sc) {
		System.out.println("********Welcome to Pizza Store*******");
		System.out.println("0.EXIT");
		System.out.println("1.LOGIN");
		System.out.println("2.REGISTER");
		System.out.println("3.ADMIN");
		System.out.println("**************************************");
		System.out.println("Enter your choice := ");
		int choice = sc.nextInt();
		return choice;
	}

	private static void register(Scanner sc) {
		Customer customer = new Customer();
		customer.accept(sc);
		try (CustomerDAO customerDAO = new CustomerDAO()) {
			customerDAO.insertCustomer(customer);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		System.out.println("Resgistered Sucessfully ...");
	}

	private static Customer login(Scanner sc) {
		System.out.println("Enter email :=");
		String email = sc.next();
		System.out.println("Enter Passwod :=");
		String password = sc.next();
		try (CustomerDAO customerDAO = new CustomerDAO()) {

			return customerDAO.getCustomer(email, password);

		} catch (SQLException e) {
			e.printStackTrace();
		}
		return null;

	}

	private static Admin adminlogin(Scanner sc) {
		System.out.println("Enter email :=");
		String email = sc.next();
		System.out.println("Enter Passwod :=");
		String password = sc.next();
		try (AdminDAO adminDAO = new AdminDAO()) {

			Admin admin = adminDAO.getAdmin(email, password);
			return admin;

		} catch (SQLException e) {
			e.printStackTrace();
		}
		return null;

	}

	public static void main(String[] args) {

		int choice = 1;
		Scanner sc = new Scanner(System.in);
		while ((choice = menu(sc)) != 0) {
			switch (choice) {
			case 1:
				Customer customer = login(sc);
				if (customer != null) {
					System.out.println("Login Sucessfully");
					SubMenu.SubMenu(sc, customer);

				} else
					System.out.println("Invalid Credentials.....");

				break;

			case 2:
				register(sc);
				break;

			case 3:
				Admin admin = adminlogin(sc);
				if (admin != null) {
					AdminMenu.AdminMenu(sc, admin);
				} else {
					System.out.println("Invalid credentials..");
				}
				break;
			default:
				System.out.println("Wrong choice!......");
			}
		}
		System.out.println("Thankyou for using Your application....");

	}

}
