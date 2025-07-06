package com.dkte.pizzashop.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import com.dkte.pizzashop.entities.Admin;
import com.dkte.pizzashop.utils.DBUtil;

public class AdminDAO implements AutoCloseable {

	private Connection connection;

	public AdminDAO() throws SQLException {
		connection = DBUtil.getConnection();
	}

	@Override
	public void close() throws SQLException {
		connection.close();
	}

	public Admin getAdmin(String email, String password) throws SQLException {
		String sql = "SELECT * FROM employee WHERE email=? AND password=?";
		Admin admin = new Admin();

		try (PreparedStatement selectStatement = connection.prepareCall(sql)) {
			selectStatement.setString(1, email);
			selectStatement.setString(2, password);
			ResultSet rs = selectStatement.executeQuery();
			while (rs.next()) {
				admin.setEmpid(rs.getInt(1));
				admin.setName(rs.getString(2));
				admin.setEmail(email);
				admin.setPassword(password);
				admin.setMobile(rs.getString(5));
				admin.setSalary(rs.getDouble(6));
				return admin;
			}
		} catch (SQLException e) {

		}
		return null;
	}

}
