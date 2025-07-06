package com.dkte.pizzashop.utils;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DBUtil {


	final  static private String URL="jdbc:mysql://localhost:3306/pizzastore_db";
    final static  private String USER ="root";
    final static private String PASSWORD="root";
    
    public static  Connection getConnection() throws SQLException {
    	return DriverManager.getConnection(URL, USER, PASSWORD);
		
	}

}
