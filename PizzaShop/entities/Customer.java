package com.dkte.pizzashop.entities;

import java.util.Scanner;

public class Customer {

	private int id;
	private String name;
	private String email;
	private String password;
	private String mobile;

	public Customer() {

	}

	public Customer(int id, String name, String email, String password, String mobile) {
		this.id = id;
		this.name = name;
		this.email = email;
		this.password = password;
		this.mobile = mobile;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public String getMobile() {
		return mobile;
	}

	public void setMobile(String mobile) {
		this.mobile = mobile;
	}

	public void accept(Scanner sc) {
		sc.nextLine();
		System.out.println("Enter Customer name :-");
		this.name = sc.nextLine();
		System.out.println("Enter customer email :-");
		this.email = sc.next();
		System.out.println("Enter customer password :-");
		this.password = sc.next();
		System.out.println("Enter customer Mobile :-");
		this.mobile = sc.next();
	}

	public void display() {
		System.out.println(" " + name + "\t " + email + "\t" + password + "\t" + mobile);

	}

	@Override
	public String toString() {
		return "customer[id " + id + " name " + name + " email" + email + " password " + password + "mobile " + mobile
				+ "]";
	}

}
