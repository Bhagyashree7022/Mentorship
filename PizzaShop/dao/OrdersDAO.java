package com.dkte.pizzashop.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import com.dkte.pizzashop.entities.Order;
import com.dkte.pizzashop.entities.Pizza;
import com.dkte.pizzashop.utils.DBUtil;

public class OrdersDAO implements AutoCloseable {

	private Connection connection;

	public OrdersDAO() throws SQLException {
		connection = DBUtil.getConnection();
	}

	public void orderPizza(int cid, int mid) throws SQLException {
		String sql = "INSERT INTO orders(cid,mid) VALUES (?,?)";
		try (PreparedStatement orderStatement = connection.prepareCall(sql)) {
			orderStatement.setInt(1, cid);
			orderStatement.setInt(2, mid);
			orderStatement.executeUpdate();
		}
	}

	public List<Pizza> orderHistory(int cid) throws SQLException {
		String sql = "SELECT m.mid,name,description ,price FROM menu m INNER JOIN orders o ON m.mid=o.mid WHERE o.cid =?";
		List<Pizza> pizzaList = new ArrayList<Pizza>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			selectStatment.setInt(1, cid);
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Pizza pizza = new Pizza();
				pizza.setMid(rs.getInt(1));
				pizza.setName(rs.getString(2));
				pizza.setDescription(rs.getString(3));
				pizza.setprice(rs.getDouble(4));
				pizzaList.add(pizza);

			}
		}
		return pizzaList;

	}

	public List<Order> getAllOrders() throws SQLException {
		String sql = "SELECT * FROM orders";
		List<Order> orderList = new ArrayList<Order>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Order order = new Order();
				order.setOid(rs.getInt(1));
				order.setCid(rs.getInt(2));
				order.setMid(rs.getInt(3));
				orderList.add(order);

			}
		}
		return orderList;

	}

	@Override
	public void close() throws SQLException {

		if (connection != null) {
			connection.close();
		}
	}

}
