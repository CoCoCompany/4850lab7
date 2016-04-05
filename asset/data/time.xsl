<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Timetable in days</title>
            </head>
            <body>
                <h1>CIT4B timetable day facet</h1>
                <xsl:call-template name="timetable"/>
            </body>
        </html>
    </xsl:template> 
    <xsl:template name="timetable">
        <table border="solid">
            <tr>
                <th>Hours</th>
                <xsl:for-each select="/data/timefacet/timeslot">
					<xsl:sort select="substring(substring-before(@whichtime, '-'), 5)"/>
					<xsl:call-template name="timeslot"/>
				</xsl:for-each>
            </tr>
            <xsl:for-each select="/data/dayfacet/day">
                <xsl:sort select="substring(substring-before(@whichday, '-'), 5)"/>
                <xsl:call-template name="day"/>
            </xsl:for-each>
        </table>   
    </xsl:template>
    <xsl:template name="day">
        <tr>
            <td>
                <xsl:value-of select="@whichday"/>
            </td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@clock = '08:30-09:30'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
			
          
        </tr>
    </xsl:template>
    <xsl:template name="booking">
        
            <xsl:value-of select="@course"/><br/>
            <xsl:value-of select="@instructor"/><br/>
            <xsl:value-of select="@room"/><br/>
        
    </xsl:template>
	<xsl:template name="timeslot">
		<th><xsl:value-of select="@whichtime" /></th>
	</xsl:template>
	
        
</xsl:stylesheet>