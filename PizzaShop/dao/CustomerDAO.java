package com.dkte.pizzashop.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import com.dkte.pizzashop.entities.Customer;
import com.dkte.pizzashop.utils.DBUtil;

public class CustomerDAO implements AutoCloseable {

	private Connection connection;

	public CustomerDAO() throws SQLException {
		connection = DBUtil.getConnection();
	}

	public void insertCustomer(Customer customer) throws SQLException {

		String sql = "INSERT INTO CUSTOMER (name,email, password, mobile) VALUE (?,?,?,?)";
		try (PreparedStatement insertStatement = connection.prepareCall(sql)) {
			insertStatement.setString(1, customer.getName());
			insertStatement.setString(2, customer.getEmail());
			insertStatement.setString(3, customer.getPassword());
			insertStatement.setString(4, customer.getMobile());
			insertStatement.executeUpdate();
		}
	}

	public Customer getCustomer(String email, String password) throws SQLException {
		String sql = "SELECT * FROM Customer WHERE email=? AND password=?";
		Customer customer = new Customer();

		try (PreparedStatement selectStatement = connection.prepareCall(sql)) {
			selectStatement.setString(1, email);
			selectStatement.setString(2, password);
			ResultSet rs = selectStatement.executeQuery();
			while (rs.next()) {
				customer.setId(rs.getInt(1));
				customer.setName(rs.getString(2));
				customer.setEmail(email);
				customer.setPassword(password);
				customer.setMobile(rs.getString(5));
				return customer;
			}
		} catch (SQLException e) {

		}
		return null;
	}

	public List<Customer> getAllCustomer() throws SQLException {
		String sql = "SELECT * FROM customer";
		List<Customer> customerList = new ArrayList<Customer>();
		try (PreparedStatement selectStatment = connection.prepareCall(sql)) {
			ResultSet rs = selectStatment.executeQuery();
			while (rs.next()) {

				Customer customer = new Customer();
				customer.setId(rs.getInt(1));
				customer.setName(rs.getString(2));
				customer.setEmail(rs.getString(3));
				customer.setPassword(rs.getString(4));
				customer.setMobile(rs.getString(5));
				customerList.add(customer);

			}
		}
		return customerList;

	}

	@Override
	public void close() throws SQLException {

		if (connection != null)
			connection.close();

	}

}
