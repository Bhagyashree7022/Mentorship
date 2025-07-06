package com.dkte.pizzashop.entities;

import java.util.Scanner;

public class Pizza {
	private int mid;
	private String name;
	private String description;
	private double price;
	private String category;
	private double productionCost;

	public Pizza() {
	}

	public Pizza(String name, String description, double price, String category, double productionCost) {
		this.name = name;
		this.description = description;
		this.price = price;
		this.category = category;
		this.productionCost = productionCost;
	}

	public double getProductionCost() {
		return productionCost;
	}

	public void setProductionCost(double productionCost) {
		this.productionCost = productionCost;
	}

	public String getCategory() {
		return category;
	}

	public void setCategory(String category) {
		this.category = category;
	}

	public int getMid() {
		return mid;
	}

	public void setMid(int mid) {
		this.mid = mid;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public double getprice() {
		return price;
	}

	public void setprice(double price) {
		this.price = price;
	}

	@Override
	public String toString() {
		return mid + "	" + name + "		" + description + "				" + price;
	}

	public void displayPizzaC() {
		System.out.println("mid:=" + mid + "		pizza name := " + name + "\ndescription:= " + description
				+ "\nprice :=" + price);
	}

	public void displayDrinkC() {
		System.out.println("mid:=" + mid + "	  drinkname := " + name + "\n..description:= " + description
				+ "\n..price :=" + price);
	}

	public void displayBreadC() {
		System.out.println("mid:=" + mid + "	  Garlic bread name := " + name + "\ndescription:= " + description
				+ "\nprice :=" + price);
	}

	public void displayPizza() {
		System.out.println("mid:=" + mid + "	  pizza name := " + name + "\ndescription:= " + description
				+ "\nprice :=" + price + "		Production cost := " + productionCost);
	}

	public void displayDrink() {
		System.out.println("mid:=" + mid + "		drink name := " + name + "\ndescription:= " + description
				+ "\nprice :=" + price + "		Production cost := " + productionCost);
	}

	public void displayBread() {
		System.out.println("mid:=" + mid + "		Garlic bread name := " + name + "\ndescription:= " + description
				+ "\nprice :=" + price + "		Production cost := " + productionCost);
	}

	public void acceptPizza(Scanner sc) {
		System.out.println("Enter Pizza Name :=");
		sc.nextLine();
		this.name = sc.nextLine();
		System.out.println("Enter Pizza Desciption :=");
		this.description = sc.nextLine();
		System.out.println("Enter Price :=");
		this.price = sc.nextDouble();
		System.out.println("Enter Category:=");
		this.category = sc.next();
		System.out.println("Enter Production cost:=");
		this.productionCost = sc.nextDouble();

	}

	public void acceptDrink(Scanner sc) {
		System.out.println("Enter Drink Name :=");
		sc.nextLine();
		this.name = sc.nextLine();
		System.out.println("Enter Drink  Desciption :=");
		this.description = sc.nextLine();
		System.out.println("Enter Price :=");
		this.price = sc.nextDouble();
		System.out.println("Enter Category:=");
		this.category = sc.next();
		System.out.println("Enter Production cost:=");
		this.productionCost = sc.nextDouble();

	}

	public void acceptGarlicBread(Scanner sc) {
		System.out.println("Enter Garlic bread Name :=");
		sc.nextLine();
		this.name = sc.nextLine();
		System.out.println("Enter Drink  Desciption :=");
		this.description = sc.nextLine();
		System.out.println("Enter Price :=");
		this.price = sc.nextDouble();
		System.out.println("Enter Category:=");
		this.category = sc.next();
		System.out.println("Enter Production cost:=");
		this.productionCost = sc.nextDouble();

	}

}
