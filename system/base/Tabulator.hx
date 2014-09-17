package system.base;
import system.base.Attributes;
import system.base.Base;

class Tabulator
{	
	static public function tabulate(	o 				: Array<Dynamic>, 
										?headings 		: Array<String>, 
										?footers 		: Array<Dynamic>, 
										?table 			: WA, 
										?header 		: WA, 
										?body 			: WA, 
										?footer 		: WA, 
										?rowA 			: WA, 
										?rowB 			: WA, 
										?tcol 			: WA, 
										?tcol_pos	 	: Int
									) : String
	{
		var output 		= new StringBuf();
		var i 			: Int;
		var j 			: Int;
		var fields 		= Reflect.fields(o[0]);
		var defs		: WA;


		tcol_pos 	= (tcol_pos == null) ? 0 : tcol_pos;
		
		// Build a new table
		output.add("<table " + ((table != null) ? (table.insert_attributes()) : "") + ">");

		// has the user supplied their own headings?
		if (headings == null)
		{
			output.add("<thead" + ((header != null) ? (header.insert_attributes()) : "") + ">");
			output.add("<tr>");
			for (i in 0...fields.length)
			{
				output.add("<th>" + fields[i] + "</th>");
			}
			output.add("</tr></thead>");
		}

		// Use the heading names from the object
		else
		{
			output.add("<thead" + ((header != null) ? (header.insert_attributes()) : "") + ">");
			output.add("<tr>");
			for (i in 0...headings.length)
			{
				if (i == tcol_pos)
				{
					output.add("<th" + ((tcol != null) ? (tcol.insert_attributes()) : "") + ">" + headings[i] + "</th>");
				}
				else
				{
					output.add("<th>" + headings[i] + "</th>");
				}
			}
			output.add("</tr></thead>");
		}

		/// footers (if supplied) are rendered before the table body!
		if (footers != null)
		{
			output.add("<tfoot" + ((footer != null) ? (footer.insert_attributes()) : "") + ">");
			output.add("<tr>");
			for (i in 0...footers.length)
			{
				if (i == tcol_pos)
				{
					output.add("<td" + ((tcol != null) ? (tcol.insert_attributes()) : "") + ">" + footers[i] + "</td>");
				}
				else
				{
					output.add("<td>" + footers[i] + "</td>");
				}
			}
			output.add("</tr></tfoot>");
		}
		
		/// Now comes the main body of this table
		output.add("<tbody" + ((body != null) ? (body.insert_attributes()) : "") + ">");

		var toggle = true;

		for (i in 0...o.length)
		{			
			output.add("<tr" + ( (toggle == true) ? rowA.insert_attributes() : rowB.insert_attributes() ) + ">");
			for (j in 0...fields.length)
			{
				if (j == tcol_pos)				
				{
					output.add("<td" + ((tcol != null) ? (tcol.insert_attributes()) : "") + ">" + Reflect.field(o[i], fields[j]) + "</td>");
				}
				else
				{
					output.add("<td>" + Reflect.field(o[i], fields[j]) + "</td>");
				}
			}
			output.add("</tr>");
			toggle = (toggle == false);

		}
		
		output.add("</tbody></table>");
		
		return output.toString();
	}
}