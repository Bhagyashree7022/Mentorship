package com.dkte.pizzashop.entities;

public class Admin {

	private int empid;
	private String name;
	private String email;
	private String password;
	private String mobile;
	private double salary;

	public Admin() {
	}

	public Admin(String name, String email, String password, double salary, String mobile) {
		this.name = name;
		this.email = email;
		this.password = password;
		this.mobile = mobile;
		this.salary = salary;
	}

	public int getEmpid() {
		return empid;
	}

	public void setEmpid(int empid) {
		this.empid = empid;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public double getSalary() {
		return salary;
	}

	public void setSalary(double salary) {
		this.salary = salary;
	}

	public String getEmail() {
		return email;
	}

	public String getPassword() {
		return password;
	}

	public String getMobile() {
		return mobile;
	}

	public void setMobile(String mobile) {
		this.mobile = mobile;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public void setPassword(String password) {
		this.password = password;
	}

}
