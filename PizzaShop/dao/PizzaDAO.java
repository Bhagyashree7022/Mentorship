package com.dkte.pizzashop.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import com.dkte.pizzashop.entities.Pizza;
import com.dkte.pizzashop.utils.DBUtil;

public class PizzaDAO implements AutoCloseable {

	private Connection connection;

	public PizzaDAO() throws SQLException {
		connection = DBUtil.getConnection();
	}

	public List<Pizza> getAllPizz() throws SQLException {
		String sql = "SELECT * FROM menu";
		List<Pizza> pizzaList = new ArrayList<Pizza>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Pizza pizza = new Pizza();
				pizza.setMid(rs.getInt(1));
				pizza.setName(rs.getString(2));
				pizza.setDescription(rs.getString(3));
				pizza.setprice(rs.getDouble(4));
				pizza.setCategory(rs.getString(5));
				pizzaList.add(pizza);

			}
		}
		return pizzaList;

	}

	public void addPizza(Pizza pizza) throws SQLException {
		String sql = "INSERT  INTO menu(name,description,price,category,productioncost) VALUES(?,?,?,?,?)";
		try (PreparedStatement insertStatement = connection.prepareCall(sql)) {
			insertStatement.setString(1, pizza.getName());
			insertStatement.setString(2, pizza.getDescription());
			insertStatement.setDouble(3, pizza.getprice());
			insertStatement.setString(4, pizza.getCategory());
			insertStatement.setDouble(5, pizza.getProductionCost());
			insertStatement.executeUpdate();
		}
	}

	public void updatePizzaPrice(int mid, double Price) throws SQLException {
		String sql = "UPDATE menu SET price = ? WHERE mid =?";
		try (PreparedStatement updateStatement = connection.prepareCall(sql)) {
			updateStatement.setDouble(1, Price);
			updateStatement.setInt(2, mid);
			updateStatement.executeUpdate();
		}
	}

	public int deletePizza(int mid) throws SQLException {
		String sql = "DELETE FROM menu WHERE mid = ?";
		try (PreparedStatement deleteStatement = connection.prepareCall(sql)) {
			deleteStatement.setInt(1, mid);
			deleteStatement.executeUpdate();
			return 1;
		}
	}

	public List<Pizza> adminGetMenu(String category) throws SQLException {
		String sql = "SELECT * FROM menu where category =?";
		List<Pizza> pizzaList = new ArrayList<Pizza>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			selectStatment.setString(1, category);
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Pizza pizza = new Pizza();
				pizza.setMid(rs.getInt(1));
				pizza.setName(rs.getString(2));
				pizza.setDescription(rs.getString(3));
				pizza.setprice(rs.getDouble(4));
				pizza.setCategory(category);
				pizza.setProductionCost(rs.getDouble(6));
				pizzaList.add(pizza);

			}
		}
		return pizzaList;
	}

	public List<Pizza> customerGetMenu(String category) throws SQLException {
		String sql = "SELECT mid,name,description ,price,category   FROM menu where category =?";
		List<Pizza> pizzaList = new ArrayList<Pizza>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			selectStatment.setString(1, category);
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Pizza pizza = new Pizza();
				pizza.setMid(rs.getInt(1));
				pizza.setName(rs.getString(2));
				pizza.setDescription(rs.getString(3));
				pizza.setprice(rs.getDouble(4));
				pizza.setCategory(category);
				pizzaList.add(pizza);

			}
		}
		return pizzaList;
	}

	public double calculateProfit() throws SQLException {
		String sql = " SELECT SUM(productioncost),SUM(price) FROM menu m INNER JOIN orders o ON m.mid=o.mid";
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {
				double tCost = rs.getDouble(1);
				double tSaling = rs.getDouble(2);
				return tSaling - tCost;

			}
		}
		return 0;

	}

	@Override
	public void close() throws SQLException {
		connection.close();
	}

}
