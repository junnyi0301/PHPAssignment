<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" indent="yes"/>
  
  <xsl:template match="/">
    <html>
      <head>
        <title>User List</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
      </head>
      <body class="bg-gray-100 font-sans p-8">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
          <h1 class="text-3xl font-bold text-gray-800 mb-6">User List</h1>
          
          <!-- Total Users -->
          <p class="text-lg text-gray-700 mb-4">
            Total Users: <span class="font-semibold">
              <xsl:value-of select="count(users/user)" />
            </span>
          </p>

          <!-- Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <xsl:for-each select="users/user">
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <xsl:value-of select="id" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <xsl:value-of select="name" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <xsl:value-of select="email" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <xsl:value-of select="role" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <xsl:value-of select="created_at" />
                    </td>
                  </tr>
                </xsl:for-each>
              </tbody>
            </table>
          </div>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
